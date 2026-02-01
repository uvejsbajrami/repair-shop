<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('emails.repair_tracking_subject') }}</title>
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
                                        <span style="font-size: 24px; font-weight: bold; color: #2563eb;">{{ $repair->shop->name ?? 'MobileShop' }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Main Card -->
                    <tr>
                        <td>
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 16px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07), 0 10px 20px rgba(0, 0, 0, 0.04); overflow: hidden;">
                                <!-- Header -->
                                <tr>
                                    <td style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 40px; text-align: center;">
                                        <div style="width: 80px; height: 80px; background-color: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto 20px; line-height: 80px;">
                                            <span style="font-size: 40px;">&#9989;</span>
                                        </div>
                                        <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 700;">
                                            {{ __('emails.repair_submitted') }}
                                        </h1>
                                        <p style="margin: 12px 0 0 0; color: rgba(255,255,255,0.9); font-size: 16px;">
                                            {{ __('emails.repair_submitted_message', ['shop' => $repair->shop->name ?? '']) }}
                                        </p>
                                    </td>
                                </tr>

                                <!-- Content -->
                                <tr>
                                    <td style="padding: 40px;">
                                        <!-- Greeting -->
                                        <p style="margin: 0 0 25px 0; font-size: 16px; color: #374151; line-height: 1.6;">
                                            {{ __('repairs.customer_name') }}: <strong>{{ $repair->customer_name }}</strong>
                                        </p>

                                        <!-- Tracking Code Box -->
                                        <table width="100%" cellpadding="0" cellspacing="0" style="background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); border-radius: 12px; margin-bottom: 30px;">
                                            <tr>
                                                <td style="padding: 30px; text-align: center;">
                                                    <p style="margin: 0 0 10px 0; font-size: 14px; color: rgba(255,255,255,0.9); text-transform: uppercase; letter-spacing: 1px;">
                                                        {{ __('emails.your_tracking_code') }}
                                                    </p>
                                                    <p style="margin: 0 0 10px 0; font-size: 36px; font-weight: 700; color: #ffffff; letter-spacing: 3px; font-family: 'Courier New', monospace;">
                                                        {{ $repair->tracking_code }}
                                                    </p>
                                                    <p style="margin: 0; font-size: 13px; color: rgba(255,255,255,0.8);">
                                                        {{ __('emails.use_code_to_track') }}
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Repair Details Card -->
                                        <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9fafb; border-radius: 12px; margin-bottom: 30px;">
                                            <tr>
                                                <td style="padding: 24px;">
                                                    <h2 style="margin: 0 0 20px 0; font-size: 14px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">
                                                        &#128221; {{ __('emails.repair_details') }}
                                                    </h2>
                                                    <table width="100%" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td style="padding: 10px 0;">
                                                                <table cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td style="width: 40px; height: 40px; background-color: #2563eb; border-radius: 10px; text-align: center; vertical-align: middle;">
                                                                            <span style="color: white; font-size: 18px;">&#128241;</span>
                                                                        </td>
                                                                        <td style="padding-left: 15px;">
                                                                            <span style="display: block; font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">{{ __('emails.device') }}</span>
                                                                            <span style="display: block; font-size: 16px; color: #1f2937; font-weight: 600;">{{ $repair->device_type }}</span>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding: 10px 0;">
                                                                <table cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td style="width: 40px; height: 40px; background-color: #f59e0b; border-radius: 10px; text-align: center; vertical-align: middle;">
                                                                            <span style="color: white; font-size: 18px;">&#128295;</span>
                                                                        </td>
                                                                        <td style="padding-left: 15px;">
                                                                            <span style="display: block; font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">{{ __('emails.issue') }}</span>
                                                                            <span style="display: block; font-size: 16px; color: #1f2937; font-weight: 500;">{{ $repair->issue_description }}</span>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- CTA Button -->
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td align="center">
                                                    <a href="{{ $trackingUrl }}" style="display: inline-block; background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); color: #ffffff; text-decoration: none; padding: 16px 40px; border-radius: 10px; font-weight: 600; font-size: 16px; box-shadow: 0 4px 6px rgba(37, 99, 235, 0.3);">
                                                        {{ __('emails.track_repair_now') }} &#8594;
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Security Note -->
                                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 30px; background-color: #fef3c7; border-radius: 8px;">
                                            <tr>
                                                <td style="padding: 16px;">
                                                    <p style="margin: 0; font-size: 13px; color: #92400e;">
                                                        <strong>&#128274;</strong> {{ __('emails.keep_code_safe') }}
                                                    </p>
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
                                {{ __('emails.track_anytime') }}
                            </p>
                            <p style="margin: 0 0 15px 0; font-size: 12px; color: #9ca3af;">
                                {{ $repair->shop->name ?? 'MobileShop' }}
                            </p>
                            <p style="margin: 0; font-size: 12px; color: #9ca3af;">
                                &copy; {{ date('Y') }} {{ __('emails.all_rights_reserved') }}
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
