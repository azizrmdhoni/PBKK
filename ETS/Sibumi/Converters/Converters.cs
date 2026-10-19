using System.Globalization;
using System.Windows;
using System.Windows.Data;
using System.Windows.Media;

namespace Sibumi.Converters;

public class EqualsConverter : IValueConverter
{
    public object Convert(object value, Type t, object parameter, CultureInfo c) =>
        string.Equals(value?.ToString(), parameter?.ToString());
    public object ConvertBack(object v, Type t, object p, CultureInfo c) => throw new NotSupportedException();
}

public class StatusToBrushConverter : IValueConverter
{
    public object Convert(object value, Type t, object parameter, CultureInfo c)
    {
        var key = (value as string) switch
        {
            "Menunggu" => "WarningBrush",
            "Dikonfirmasi" => "InfoBrush",
            "Mendaki" => "AccentBrush",
            "Dibatalkan" => "DangerBrush",
            _ => "MutedBrush"
        };
        return Application.Current.TryFindResource(key) ?? Brushes.Gray;
    }
    public object ConvertBack(object v, Type t, object p, CultureInfo c) => throw new NotSupportedException();
}