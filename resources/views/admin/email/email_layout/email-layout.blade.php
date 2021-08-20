<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMAIL - USER</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th style="text-align:center;border:2px solid black;">
                    <h3 style="color:white;margin:0;padding:10px;background:linear-gradient(90deg, rgba(89,15,16,1) 0%, rgba(207,29,32,1) 100%);">TCI UDAYANA UNIVERSITY E-MAIL SYSTEM</h3>
                    <h4 style="margi10px:0;padding:0;">@yield('title')</h4>
                    <p style="margin:0;padding:0;">Subject : @yield('subject')</p>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align:center;">
                    @yield('content')
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td style="text-align:center;border:2px solid black;">
                   <p>MORE INFO : <a href="{{ url('/') }}" style="text-decoration:none;">SISTEM PENDAFTARAN TCI</a></p>
                </td>
            </tr>
        </tfoot>
    </table>
</body>
</html>