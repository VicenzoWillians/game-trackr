<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifique seu E-mail</title>
</head>
<body style="margin: 0; padding: 0; background-color: #12161b; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #ffffff;">

    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color: #12161b; padding: 40px 20px;">
        <tr>
            <td align="center">
                
                <table width="100%" max-width="500" border="0" cellpadding="0" cellspacing="0" style="background-color: #1C222B; border: 1px solid rgba(163, 89, 217, 0.2); border-radius: 16px; padding: 40px; text-align: center;">
                    
                    <tr>
                        <td align="center" style="padding-bottom: 24px;">
                            <img src="https://ui-avatars.com/api/?name=GT&background=A359D9&color=fff&rounded=true&size=100" alt="Ilustração de E-mail" width="100" height="100" style="display: block; border-radius: 50%;">
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="font-size: 24px; font-weight: bold; color: #ffffff; padding-bottom: 12px;">
                            E-mail de Verificação
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="font-size: 16px; line-height: 1.6; color: #a1a1aa; padding-bottom: 32px;">
                            Olá, <strong>{{ $name }}</strong>!<br>
                            Só falta um passo! Confirme seu endereço de e-mail clicando no botão abaixo para ativar sua conta no <strong>GameTrackr</strong> e começar a organizar sua coleção de jogos. 
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding-bottom: 20px;">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" bgcolor="#A359D9" style="border-radius: 8px;">
                                        <a href="{{ $url }}" target="_blank" style="display: inline-block; padding: 14px 28px; font-size: 16px; font-weight: bold; color: #ffffff; text-decoration: none; border-radius: 8px;">
                                            Confirmar e-mail
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="font-size: 12px; color: #71717a; line-height: 1.5;">
                            Se você não criou uma conta no GameTrackr, por favor ignore este e-mail.<br>
                            O link expira em 60 minutos.
                        </td>
                    </tr>

                </table>

                <table width="100%" max-width="500" border="0" cellpadding="0" cellspacing="0" style="margin-top: 24px;">
                    <tr>
                        <td align="center">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                                <tr>
                                    <td style="vertical-align: middle; padding-right: 6px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#A359D9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: block;">
                                            <line x1="6" x2="10" y1="11" y2="11"/>
                                            <line x1="8" x2="8" y1="9" y2="13"/>
                                            <line x1="15" x2="15.01" y1="12" y2="12"/>
                                            <line x1="18" x2="18.01" y1="10" y2="10"/>
                                            <path d="M17.32 5H6.68a4 4 0 0 0-3.978 3.59c-.006.052-.01.101-.017.152C2.604 9.416 2 14.456 2 16a3 3 0 0 0 3 3c1 0 1.5-.5 2-1l1.414-1.414A2 2 0 0 1 9.828 16h4.344a2 2 0 0 1 1.414.586L17 18c.5.5 1 1 2 1a3 3 0 0 0 3-3c0-1.545-.604-6.584-.685-7.258-.007-.05-.011-.1-.017-.151A4 4 0 0 0 17.32 5z"/>
                                        </svg>
                                    </td>
                                    <td style="vertical-align: middle; font-size: 16px; font-weight: bold; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
                                        <span style="color: #ffffff;">Game</span><span style="color: #A359D9;">Trackr</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

</body>
</html>