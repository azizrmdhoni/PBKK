using Sibumi.Core;
using Sibumi.Data;
using Sibumi.Models;

namespace Sibumi.Services;

public class AuthService
{
    readonly UserRepository _users = new();

    // Kalau tabel Users masih kosong, buat akun awal admin dan petugas
    public async Task EnsureSeedAsync()
    {
        if (await _users.CountAsync() > 0) return;
        await _users.InsertAsync("admin", "Admin#123", "Administrator", "Admin");
        await _users.InsertAsync("petugas", "Petugas#123", "Petugas Basecamp", "Petugas");
    }

    public async Task<User> LoginAsync(string username, string password)
    {
        if (string.IsNullOrWhiteSpace(username) || string.IsNullOrEmpty(password))
            throw new BusinessException("Username dan password wajib diisi.");

        var user = await _users.GetByUsernameAsync(username.Trim());
        if (user == null || !PasswordHasher.Verify(password, user.PasswordHash))
            throw new BusinessException("Username atau password salah.");
        if (!user.IsActive)
            throw new BusinessException("Akun Anda nonaktif. Hubungi administrator.");

        Session.Start(user);
        return user;
    }
}