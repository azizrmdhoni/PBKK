using System.Data;
using Microsoft.Data.SqlClient;
using Sibumi.Core;
using Sibumi.Models;

namespace Sibumi.Data;

public class JalurRepository
{
    public async Task<List<Gunung>> GetGunungAsync()
    {
        Session.RequireLogin();
        var list = new List<Gunung>();
        await using var c = Db.Create();
        await c.OpenAsync();
        await using var cmd = new SqlCommand("SELECT GunungId, NamaGunung FROM Gunung ORDER BY NamaGunung", c);
        await using var r = await cmd.ExecuteReaderAsync();
        while (await r.ReadAsync())
            list.Add(new Gunung { GunungId = r.GetInt32(0), NamaGunung = r.GetString(1) });
        return list;
    }

    public async Task<List<Jalur>> GetAllAsync(bool activeOnly = false)
    {
        Session.RequireLogin();
        var list = new List<Jalur>();
        await using var c = Db.Create();
        await c.OpenAsync();
        await using var cmd = new SqlCommand(
            @"SELECT j.JalurId, j.GunungId, g.NamaGunung, j.NamaJalur, j.KuotaHarian, j.TarifPerOrang, j.IsActive
              FROM Jalur j JOIN Gunung g ON g.GunungId = j.GunungId
              WHERE (@a = 0 OR j.IsActive = 1)
              ORDER BY g.NamaGunung, j.NamaJalur", c)
            .With("@a", SqlDbType.Bit, activeOnly);
        await using var r = await cmd.ExecuteReaderAsync();
        while (await r.ReadAsync())
            list.Add(new Jalur
            {
                JalurId = r.GetInt32(0),
                GunungId = r.GetInt32(1),
                NamaGunung = r.GetString(2),
                NamaJalur = r.GetString(3),
                KuotaHarian = r.GetInt32(4),
                TarifPerOrang = r.GetDecimal(5),
                IsActive = r.GetBoolean(6)
            });
        return list;
    }

    public async Task SaveAsync(Jalur j)
    {
        Session.RequireAdmin();
        await using var c = Db.Create();
        await c.OpenAsync();
        await using var tx = (SqlTransaction)await c.BeginTransactionAsync();
        try
        {
            var baru = j.JalurId == 0;
            var sql = baru
                ? "INSERT INTO Jalur (GunungId, NamaJalur, KuotaHarian, TarifPerOrang, IsActive) VALUES (@g, @n, @k, @t, @a)"
                : "UPDATE Jalur SET GunungId=@g, NamaJalur=@n, KuotaHarian=@k, TarifPerOrang=@t, IsActive=@a WHERE JalurId=@id";
            await using (var cmd = new SqlCommand(sql, c, tx)
                .With("@g", SqlDbType.Int, j.GunungId)
                .With("@n", SqlDbType.NVarChar, j.NamaJalur)
                .With("@k", SqlDbType.Int, j.KuotaHarian)
                .With("@t", SqlDbType.Decimal, j.TarifPerOrang)
                .With("@a", SqlDbType.Bit, j.IsActive)
                .With("@id", SqlDbType.Int, j.JalurId))
            {
                await cmd.ExecuteNonQueryAsync();
            }
            await ActivityLog.WriteAsync(c, tx, "Jalur", $"Jalur {j.NamaJalur} {(baru ? "ditambahkan" : "diperbarui")}");
            await tx.CommitAsync();
        }
        catch (SqlException ex) when (ex.Number is 2627 or 2601)
        {
            throw new BusinessException("Nama jalur sudah ada pada gunung tersebut.");
        }
    }

    public async Task DeleteAsync(Jalur j)
    {
        Session.RequireAdmin();
        await using var c = Db.Create();
        await c.OpenAsync();
        await using var tx = (SqlTransaction)await c.BeginTransactionAsync();
        try
        {
            await using (var cmd = new SqlCommand("DELETE FROM Jalur WHERE JalurId=@id", c, tx)
                .With("@id", SqlDbType.Int, j.JalurId))
            {
                await cmd.ExecuteNonQueryAsync();
            }
            await ActivityLog.WriteAsync(c, tx, "Jalur", $"Jalur {j.NamaJalur} dihapus");
            await tx.CommitAsync();
        }
        catch (SqlException ex) when (ex.Number == 547)
        {
            throw new BusinessException("Jalur sudah dipakai booking dan tidak dapat dihapus. Nonaktifkan saja.");
        }
    }
}