<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Contact Message</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f0f4f8; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f0f4f8; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="max-width: 600px; width: 100%;">
                    <!-- Logo Header -->
                    <tr>
                        <td align="center" style="padding-bottom: 30px;">
                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); width: 50px; height: 50px; border-radius: 12px; text-align: center; vertical-align: middle;">
                                        <span style="color: white; font-size: 24px;">&#128241;</span>
                                    </td>
                                    <td style="padding-left: 12px;">
                                        <span style="font-size: 24px; font-weight: bold; color: #2563eb;">MobileShop</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Main Card -->
                    <tr>
                        <td>
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 16px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07), 0 10px 20px rgba(0, 0, 0, 0.04); overflow: hidden;">
                                <!-- Blue Header -->
                                <tr>
                                    <td style="background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); padding: 30px 40px;">
                                        <h1 style="margin: 0; color: #ffffff; font-size: 24px; font-weight: 600;">
                                            &#9993; New Contact Message
                                        </h1>
                                        <p style="margin: 8px 0 0 0; color: rgba(255,255,255,0.8); font-size: 14px;">
                                            You have received a new inquiry from your website
                                        </p>
                                    </td>
                                </tr>

                                <!-- Content -->
                                <tr>
                                    <td style="padding: 40px;">
                                        <!-- Sender Info Card -->
                                        <table width="100%" cellpadding="0" cellspacing="0" style="background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%); border-radius: 12px; padding: 24px; margin-bottom: 30px;">
                                            <tr>
                                                <td>
                                                    <table width="100%" cellpadding="0" cellspacing="0">
                                                        <!-- Name -->
                                                        <tr>
                                                            <td style="padding: 12px 20px;">
                                                                <table cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td style="width: 40px; height: 40px; background-color: #2563eb; border-radius: 10px; text-align: center; vertical-align: middle;">
                                                                            <span style="color: white; font-size: 18px;">&#128100;</span>
                                                                        </td>
                                                                        <td style="padding-left: 15px;">
                                                                            <span style="display: block; font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">From</span>
                                                                            <span style="display: block; font-size: 16px; color: #1f2937; font-weight: 600;">{{ $name }}</span>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>

                                                        <!-- Email -->
                                                        <tr>
                                                            <td style="padding: 12px 20px;">
                                                                <table cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td style="width: 40px; height: 40px; background-color: #10b981; border-radius: 10px; text-align: center; vertical-align: middle;">
                                                                            <span style="color: white; font-size: 18px;">&#9993;</span>
                                                                        </td>
                                                                        <td style="padding-left: 15px;">
                                                                            <span style="display: block; font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">Email</span>
                                                                            <a href="mailto:{{ $email }}" style="display: block; font-size: 16px; color: #2563eb; font-weight: 500; text-decoration: none;">{{ $email }}</a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>

                                                        <!-- Phone -->
                                                        <tr>
                                                            <td style="padding: 12px 20px;">
                                                                <table cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td style="width: 40px; height: 40px; background-color: #8b5cf6; border-radius: 10px; text-align: center; vertical-align: middle;">
                                                                            <span style="color: white; font-size: 18px;">&#128222;</span>
                                                                        </td>
                                                                        <td style="padding-left: 15px;">
                                                                            <span style="display: block; font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">Phone</span>
                                                                            <a href="tel:{{ $phone }}" style="display: block; font-size: 16px; color: #1f2937; font-weight: 500; text-decoration: none;">{{ $phone }}</a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Message Section -->
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td>
                                                    <h2 style="margin: 0 0 15px 0; font-size: 14px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">
                                                        &#128172; Message
                                                    </h2>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="background-color: #f9fafb; border-radius: 12px; padding: 24px; border-left: 4px solid #2563eb;">
                                                    <p style="margin: 0; font-size: 15px; line-height: 1.7; color: #374151;">
                                                        {!! nl2br(e($messageContent)) !!}
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Reply Button -->
                                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 30px;">
                                            <tr>
                                                <td align="center">
                                                    <a href="mailto:{{ $email }}" style="display: inline-block; background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 8px; font-weight: 600; font-size: 14px; box-shadow: 0 4px 6px rgba(37, 99, 235, 0.3);">
                                                        Reply to {{ $name }}
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 30px 20px; text-align: center;">
                            <p style="margin: 0 0 8px 0; font-size: 13px; color: #6b7280;">
                                This message was sent from the MobileShop contact form.
                            </p>
                            <p style="margin: 0; font-size: 12px; color: #9ca3af;">
                                &copy; {{ date('Y') }} MobileShop. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
