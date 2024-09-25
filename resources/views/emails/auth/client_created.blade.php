@extends("emails.layouts.layout")

@section("content")
<table cellpadding="0" cellspacing="0" width="100%" bgcolor="#FFFFFF" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:separate;border-spacing:0px;border-width:10px;border-style:solid;border-color:transparent;background-color:#ffffff;border-radius:32px">
    <tr>
        <td align="center" style="padding:0;margin:0;padding-top:30px">
            <p style="margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:54px;color:#E6641C;font-size:36px">
                <strong>¡Bienvenid@!</strong>
            </p>
        </td>
    </tr>
    <tr>
        <td align="center" style="padding:0;margin:0;padding-top:15px;padding-bottom:20px;border-bottom: 1px solid #D9EEF2;">
            <p style="margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:36px;color:#0a1b33;font-size:24px">
                Cuenta creada satisfactoriamente
            </p>
        </td>
    </tr>
    <tr>
        <td align="center" style="padding:0;margin:0;padding-top:10px;padding-bottom:15px">
            <p style="margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:36px;color:#0a1b33;font-size:24px">
                <strong>Hola, {{$data['user']}}</strong>
            </p>
        </td>
    </tr>
    <tr>
        <td align="center" style="padding:0;margin:0;padding-bottom:15px;padding-left:15px;padding-right:15px">
            <p style="margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:19px;color:#0a1b33;font-size:16px">
                Te damos la bienvenida, hemos creado satisfactoriamente tu cuenta de usuario para que puedas disfrutar de nuestros eventos.
            </p>
        </td>
    </tr>
    <tr>
        <td align="center" style="padding:0;margin:0;padding-top:15px;padding-bottom:15px;border-bottom: 1px solid #D9EEF2;">
            <p style="margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:36px;color:#0a1b33;font-size:24px">
                Usuario:&nbsp;<br>
                <strong>{{$data['email']}}</strong>
            </p>
            <p style="margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:36px;color:#0a1b33;font-size:24px">
                <br>
            </p>
            <p style="margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:36px;color:#0a1b33;font-size:24px">
                Contraseña de acceso:&nbsp;<br>
                <strong>{{$data['password']}}</strong>
            </p>
        </td>
    </tr>
    <tr>
        <td align="center" style="padding:0;margin:0;padding-bottom:15px;padding-top:30px">
            <p style="margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:27px;color:#0a1b33;font-size:18px">
                Descarga nuestra APP
            </p>
        </td>
    </tr>
    <tr>
        <td align="center" style="padding:0;margin:0;padding-bottom:10px;">
            <span class="es-button-border" style="border-style:solid;border-color:#2CB543;background:#E6641C;border-width:0px 0px 2px 0px;border-radius:32px;width:auto;border-bottom-width:0px">
                <a href="#" class="es-button" target="_blank" style="mso-style-priority:100 !important;text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:#FFFFFF;font-size:16px;padding:10px 20px 10px 20px;background:#E6641C;border-radius:32px;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-weight:normal;font-style:normal;line-height:19px;width:auto;text-align:center;mso-padding-alt:0;mso-border-alt:10px solid #0a1b33;padding-left:5px;padding-right:5px;justify-content:center;display:flex;align-items:center;">
                    <img src="{{ url('/images/google-play.png') }}" width="24" style="margin-right:5px">
                    Google Play
                </a>
            </span>
        </td>
    </tr>
    <tr>
        <td align="center" style="padding:0;margin:0;padding-bottom:40px;">
            <span class="es-button-border" style="border-style:solid;border-color:#2CB543;background:#E6641C;border-width:0px 0px 2px 0px;border-radius:32px;width:auto;border-bottom-width:0px">
                <a href="https://apps.apple.com/co/app/viicumbrepetroleoygas/id6698888746" class="es-button" target="_blank" style="mso-style-priority:100 !important;text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:#FFFFFF;font-size:16px;padding:10px 20px 10px 20px;background:#E6641C;border-radius:32px;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-weight:normal;font-style:normal;line-height:19px;width:auto;text-align:center;mso-padding-alt:0;mso-border-alt:10px solid #0a1b33;padding-left:5px;padding-right:5px;justify-content:center;display:flex;align-items:center;">
                    <img src="{{ url('/images/ios.png') }}" width="24" style="margin-right:5px">
                    IOS App Store
                </a>
            </span>
        </td>
    </tr>
</table>
@endsection