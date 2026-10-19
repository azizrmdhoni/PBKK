using Sibumi.Models;

namespace Sibumi.Core;

public static class Session
{
    public static User CurrentUser { get; private set; }
    public static bool IsAdmin => CurrentUser?.Role == "Admin";

    public static void Start(User u) => CurrentUser = u;
    public static void End() => CurrentUser = null;

    public static void RequireLogin()
    {
        if (CurrentUser == null) throw new UnauthorizedAccessException();
    }

    public static void RequireAdmin()
    {
        RequireLogin();
        if (!IsAdmin) throw new UnauthorizedAccessException();
    }
}