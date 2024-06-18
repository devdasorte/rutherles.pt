<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="color-scheme" content="light">
<meta name="supported-color-schemes" content="light">
</head>
<body>
<style>html,body { padding: 0; margin:0; }</style>
<div style="font-family:Poppins,Helvetica,sans-serif; line-height: 1.5; font-weight: normal; font-size: 15px; color: #2F3044; min-height: 100%; margin:0; padding:0; width:100%; background-color:#edf2f7">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;margin:0 auto; padding:0; max-width:600px">
        <tbody>
        <tr>
            <td align="center" valign="center" style="text-align:center; padding: 40px">
                <a href="{{ route('home') }}" rel="noopener" target="_blank">
                    <img alt="Logo" src="{{ Utility::getpath('logo/app-logo.png') }}" width="100px" />
                </a>
            </td>
        </tr>
        <tr>
            <td align="left" valign="center">
                <div style="text-align:left; margin: 0 20px; padding: 40px; background-color:#ffffff; border-radius: 6px">
                    <!--begin:Email content-->
                    @{{{ body }}}
                    <!--end:Email content-->
                </div>
            </td>
        <tr>
            <td align="center" valign="center" style="font-size: 13px; text-align:center;padding: 20px; color: #7e8299;font-weight: 500">
                <p style="margin: auto">
                
                    <div>
                        © {{ date('Y') }} • {{ config('app.name') }} • All right reserved.
                    </div>
                </p>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
