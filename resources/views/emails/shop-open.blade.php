<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to MobileShop</title>
</head>

<body
    style="margin: 0; padding: 0; background-color: #f0f4f8; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f0f4f8; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="max-width: 600px; width: 100%;">
                    <!-- Logo Header -->
                    <tr>
                        <td align="center" style="padding-bottom: 30px;">
                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td
                                        style="background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); width: 50px; height: 50px; border-radius: 12px; text-align: center; vertical-align: middle;">
                                        <span style="color: white; font-size: 24px;">&#128241;</span>
                                    </td>
                                    <td style="padding-left: 12px;">
                                        <span
                                            style="font-size: 24px; font-weight: bold; color: #2563eb;">MobileShop</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Main Card -->
                    <tr>
                        <td>
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="background-color: #ffffff; border-radius: 16px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07), 0 10px 20px rgba(0, 0, 0, 0.04); overflow: hidden;">
                                <!-- Success Header -->
                                <tr>
                                    <td
                                        style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 40px; text-align: center;">
                                        <div
                                            style="width: 80px; height: 80px; background-color: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto 20px; line-height: 80px;">
                                            <span style="font-size: 40px;">&#127881;</span>
                                        </div>
                                        <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 700;">
                                            Welcome to MobileShop!
                                        </h1>
                                        <p style="margin: 12px 0 0 0; color: rgba(255,255,255,0.9); font-size: 16px;">
                                            Your shop is now ready to manage repairs
                                        </p>
                                    </td>
                                </tr>

                                <!-- Content -->
                                <tr>
                                    <td style="padding: 40px;">
                                        <!-- Greeting -->
                                        <p
                                            style="margin: 0 0 25px 0; font-size: 16px; color: #374151; line-height: 1.6;">
                                            Hi <strong>{{ $user->name }}</strong>,
                                        </p>
                                        <p
                                            style="margin: 0 0 30px 0; font-size: 16px; color: #374151; line-height: 1.6;">
                                            Thank you for your purchase! Your payment has been confirmed and your repair
                                            shop management system is now active. You can start adding repairs and
                                            managing your business right away.
                                        </p>

                                        <!-- Shop Details Card -->
                                        <table width="100%" cellpadding="0" cellspacing="0"
                                            style="background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%); border-radius: 12px; margin-bottom: 25px;">
                                            <tr>
                                                <td style="padding: 24px;">
                                                    <h2
                                                        style="margin: 0 0 20px 0; font-size: 14px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">
                                                        &#127978; Shop Details
                                                    </h2>
                                                    <table width="100%" cellpadding="0" cellspacing="0">
                                                        <!-- Shop Name -->
                                                        <tr>
                                                            <td style="padding: 10px 0;">
                                                                <table cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td
                                                                            style="width: 40px; height: 40px; background-color: #2563eb; border-radius: 10px; text-align: center; vertical-align: middle;">
                                                                            <span
                                                                                style="color: white; font-size: 18px;">&#127970;</span>
                                                                        </td>
                                                                        <td style="padding-left: 15px;">
                                                                            <span
                                                                                style="display: block; font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">Shop
                                                                                Name</span>
                                                                            <span
                                                                                style="display: block; font-size: 16px; color: #1f2937; font-weight: 600;">{{ $shop->name }}</span>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>

                                                        @if ($shop->phone)
                                                            <!-- Phone -->
                                                            <tr>
                                                                <td style="padding: 10px 0;">
                                                                    <table cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td
                                                                                style="width: 40px; height: 40px; background-color: #8b5cf6; border-radius: 10px; text-align: center; vertical-align: middle;">
                                                                                <span
                                                                                    style="color: white; font-size: 18px;">&#128222;</span>
                                                                            </td>
                                                                            <td style="padding-left: 15px;">
                                                                                <span
                                                                                    style="display: block; font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">Phone</span>
                                                                                <span
                                                                                    style="display: block; font-size: 16px; color: #1f2937; font-weight: 500;">{{ $shop->phone }}</span>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        @endif

                                                        @if ($shop->address)
                                                            <!-- Address -->
                                                            <tr>
                                                                <td style="padding: 10px 0;">
                                                                    <table cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td
                                                                                style="width: 40px; height: 40px; background-color: #f59e0b; border-radius: 10px; text-align: center; vertical-align: middle;">
                                                                                <span
                                                                                    style="color: white; font-size: 18px;">&#128205;</span>
                                                                            </td>
                                                                            <td style="padding-left: 15px;">
                                                                                <span
                                                                                    style="display: block; font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">Address</span>
                                                                                <span
                                                                                    style="display: block; font-size: 16px; color: #1f2937; font-weight: 500;">{{ $shop->address }}</span>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Subscription Details Card -->
                                        <table width="100%" cellpadding="0" cellspacing="0"
                                            style="background: linear-gradient(135deg, #fef3c7 0%, #fef9c3 100%); border-radius: 12px; margin-bottom: 25px;">
                                            <tr>
                                                <td style="padding: 24px;">
                                                    <h2
                                                        style="margin: 0 0 20px 0; font-size: 14px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">
                                                        &#11088; Subscription Details
                                                    </h2>
                                                    <table width="100%" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td style="padding: 8px 0;">
                                                                <table width="100%" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td style="font-size: 14px; color: #6b7280;">
                                                                            Plan</td>
                                                                        <td
                                                                            style="font-size: 16px; color: #1f2937; font-weight: 600; text-align: right;">
                                                                            {{ $plan->name }}</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding: 8px 0;">
                                                                <table width="100%" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td style="font-size: 14px; color: #6b7280;">
                                                                            Duration</td>
                                                                        <td
                                                                            style="font-size: 16px; color: #1f2937; font-weight: 600; text-align: right;">
                                                                            {{ $durationMonths }}
                                                                            {{ $durationMonths === 1 ? 'Month' : 'Months' }}
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding: 8px 0;">
                                                                <table width="100%" cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td style="font-size: 14px; color: #6b7280;">
                                                                            Amount Paid</td>
                                                                        <td
                                                                            style="font-size: 18px; color: #059669; font-weight: 700; text-align: right;">
                                                                            &euro;{{ number_format($totalPrice, 2) }}
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Plan Features -->
                                        <table width="100%" cellpadding="0" cellspacing="0"
                                            style="background-color: #f9fafb; border-radius: 12px; margin-bottom: 30px;">
                                            <tr>
                                                <td style="padding: 24px;">
                                                    <h2
                                                        style="margin: 0 0 15px 0; font-size: 14px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">
                                                        &#9989; Your Plan Includes
                                                    </h2>
                                                    <table width="100%" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td
                                                                style="padding: 8px 0; font-size: 14px; color: #374151;">
                                                                <span
                                                                    style="color: #10b981; margin-right: 8px;">&#10003;</span>
                                                                Up to
                                                                <strong>{{ $plan->max_employees == -1 ? 'Unlimited' : $plan->max_employees }}</strong>
                                                                employees
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                style="padding: 8px 0; font-size: 14px; color: #374151;">
                                                                <span
                                                                    style="color: #10b981; margin-right: 8px;">&#10003;</span>
                                                                Up to
                                                                <strong>{{ $plan->max_active_repairs == -1 ? 'Unlimited' : $plan->max_active_repairs }}</strong>
                                                                active repairs
                                                            </td>
                                                        </tr>
                                                        @if ($plan->drag_and_drop)
                                                            <tr>
                                                                <td
                                                                    style="padding: 8px 0; font-size: 14px; color: #374151;">
                                                                    <span
                                                                        style="color: #10b981; margin-right: 8px;">&#10003;</span>
                                                                    Drag & drop repair board
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        @if ($plan->exports)
                                                            <tr>
                                                                <td
                                                                    style="padding: 8px 0; font-size: 14px; color: #374151;">
                                                                    <span
                                                                        style="color: #10b981; margin-right: 8px;">&#10003;</span>
                                                                    Export repairs data
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        @if ($plan->branding)
                                                            <tr>
                                                                <td
                                                                    style="padding: 8px 0; font-size: 14px; color: #374151;">
                                                                    <span
                                                                        style="color: #10b981; margin-right: 8px;">&#10003;</span>
                                                                    Custom branding
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- CTA Button -->
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td align="center">
                                                    <a href="{{ route('owner.dashboard') }}"
                                                        style="display: inline-block; background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); color: #ffffff; text-decoration: none; padding: 16px 40px; border-radius: 10px; font-weight: 600; font-size: 16px; box-shadow: 0 4px 6px rgba(37, 99, 235, 0.3);">
                                                        Go to Dashboard &#8594;
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Tips Section -->
                                        <table width="100%" cellpadding="0" cellspacing="0"
                                            style="margin-top: 35px; border-top: 1px solid #e5e7eb; padding-top: 30px;">
                                            <tr>
                                                <td>
                                                    <h2
                                                        style="margin: 0 0 20px 0; font-size: 16px; color: #1f2937; font-weight: 600;">
                                                        &#128161; Quick Tips to Get Started
                                                    </h2>
                                                    <table width="100%" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td style="padding: 10px 0;">
                                                                <table cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td
                                                                            style="width: 30px; height: 30px; background-color: #dbeafe; border-radius: 50%; text-align: center; vertical-align: middle; font-weight: bold; color: #2563eb; font-size: 14px;">
                                                                            1</td>
                                                                        <td
                                                                            style="padding-left: 12px; font-size: 14px; color: #4b5563;">
                                                                            Add your first employee from the Employees
                                                                            section</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding: 10px 0;">
                                                                <table cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td
                                                                            style="width: 30px; height: 30px; background-color: #dbeafe; border-radius: 50%; text-align: center; vertical-align: middle; font-weight: bold; color: #2563eb; font-size: 14px;">
                                                                            2</td>
                                                                        <td
                                                                            style="padding-left: 12px; font-size: 14px; color: #4b5563;">
                                                                            Create your first repair ticket to track a
                                                                            device</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding: 10px 0;">
                                                                <table cellpadding="0" cellspacing="0">
                                                                    <tr>
                                                                        <td
                                                                            style="width: 30px; height: 30px; background-color: #dbeafe; border-radius: 50%; text-align: center; vertical-align: middle; font-weight: bold; color: #2563eb; font-size: 14px;">
                                                                            3</td>
                                                                        <td
                                                                            style="padding-left: 12px; font-size: 14px; color: #4b5563;">
                                                                            Customize your shop settings and preferences
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
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
                                Need help? Contact our support team anytime.
                            </p>
                            <p style="margin: 0 0 15px 0; font-size: 12px; color: #9ca3af;">
                                You're receiving this email because you created a shop on MobileShop.
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
