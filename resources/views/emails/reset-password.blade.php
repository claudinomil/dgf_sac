<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Recuperação de senha</title>
    </head>

    <body style="margin:0;background:#f6f6f6;font-family:Arial, Helvetica, sans-serif;">
        <table width="100%" bgcolor="#f6f6f6" cellpadding="0" cellspacing="0">
            <tr>
                <td align="center">
                    <table width="600" bgcolor="#ffffff" style="margin-top:40px;border-radius:8px;overflow:hidden">
                        <tr>
                            <td style="background:#556ee6;color:white;padding:20px;font-size:20px">CBMERJ - DGF - SAC</td>
                        </tr>
                        <tr>
                            <td style="padding:30px">
                                <p>Olá <strong>{{ $user->name }}</strong>,</p>
                                <p>Recebemos uma solicitação para redefinir sua senha no sistema.</p>
                                <p style="text-align:center;margin:40px 0">
                                    <a href="{{ $url }}" style="background:#556ee6; color:white; padding:14px 28px; text-decoration:none; border-radius:6px; font-weight:bold; display:inline-block;">REDEFINIR SENHA</a>
                                </p>
                                <p>Este link expira em <strong>60 minutos</strong>.</p>
                                <p>Se você não solicitou a redefinição de senha, ignore este email.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="background:#f1f1f1;padding:15px;font-size:12px;color:#666;text-align:center">© {{ date('Y') }} CBMERJ DGF</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
