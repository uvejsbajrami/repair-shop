<!DOCTYPE html>
<html>

<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>Plan Grace Period Warning - MobileShop</title>
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
          <span style="font-size: 24px; font-weight: bold; color: #2563eb;">MobileShop</span>
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

        <!-- WARNING HEADER - Orange/Amber Style -->
        <tr>
         <td style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); padding: 40px; text-align: center;">
          <div
           style="width: 80px; height: 80px; background-color: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto 20px; line-height: 80px;">
           <span style="font-size: 40px;">&#9888;</span>
          </div>
          <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 700;">
           Grace Period Warning
          </h1>
          <p style="margin: 12px 0 0 0; color: rgba(255,255,255,0.9); font-size: 16px;">
           Your plan has entered the grace period
          </p>
         </td>
        </tr>

        <!-- Content -->
        <tr>
         <td style="padding: 40px;">
          <!-- Greeting -->
          <p style="margin: 0 0 25px 0; font-size: 16px; color: #374151; line-height: 1.6;">
           Hi <strong>{{ $shop->owner->name }}</strong>,
          </p>

          <p style="margin: 0 0 30px 0; font-size: 16px; color: #374151; line-height: 1.6;">
           Your <strong>{{ $plan->name }}</strong> plan for <strong>{{ $shop->name }}</strong> has expired
           and is now in the grace period. You have limited time to renew your subscription before losing access.
          </p>

          <!-- Days Left Counter -->
          <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 25px;">
           <tr>
            <td align="center">
             <div
              style="display: inline-block; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: 16px; padding: 25px 40px; text-align: center;">
              <span
               style="display: block; font-size: 48px; font-weight: 700; color: #92400e;">{{ $daysLeft }}</span>
              <span style="display: block; font-size: 14px; color: #a16207; text-transform: uppercase; letter-spacing: 1px;">
               {{ $daysLeft === 1 ? 'Day' : 'Days' }} Remaining
              </span>
             </div>
            </td>
           </tr>
          </table>

          <!-- Warning Badge -->
          <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 25px;">
           <tr>
            <td align="center">
             <span
              style="display: inline-block; background-color: #fef3c7; color: #92400e; padding: 10px 20px; border-radius: 20px; font-size: 14px; font-weight: 600;">
              &#9888; Status: Grace Period
             </span>
            </td>
           </tr>
          </table>

          <!-- Plan Details Card -->
          <table width="100%" cellpadding="0" cellspacing="0"
           style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); border-radius: 12px; border-left: 4px solid #f59e0b; margin-bottom: 25px;">
           <tr>
            <td style="padding: 24px;">
             <h2
              style="margin: 0 0 20px 0; font-size: 14px; color: #92400e; text-transform: uppercase; letter-spacing: 0.5px;">
              &#128203; Plan Details
             </h2>
             <table width="100%" cellpadding="0" cellspacing="0">
              <tr>
               <td style="padding: 8px 0;">
                <table width="100%" cellpadding="0" cellspacing="0">
                 <tr>
                  <td style="font-size: 14px; color: #6b7280;">Shop Name</td>
                  <td style="font-size: 16px; color: #1f2937; font-weight: 600; text-align: right;">
                   {{ $shop->name }}
                  </td>
                 </tr>
                </table>
               </td>
              </tr>
              <tr>
               <td style="padding: 8px 0;">
                <table width="100%" cellpadding="0" cellspacing="0">
                 <tr>
                  <td style="font-size: 14px; color: #6b7280;">Plan</td>
                  <td style="font-size: 16px; color: #1f2937; font-weight: 600; text-align: right;">
                   {{ $plan->name }}
                  </td>
                 </tr>
                </table>
               </td>
              </tr>
              <tr>
               <td style="padding: 8px 0;">
                <table width="100%" cellpadding="0" cellspacing="0">
                 <tr>
                  <td style="font-size: 14px; color: #6b7280;">Expired On</td>
                  <td style="font-size: 16px; color: #1f2937; font-weight: 600; text-align: right;">
                   {{ $shopPlan->ends_at->format('d M Y') }}
                  </td>
                 </tr>
                </table>
               </td>
              </tr>
              <tr>
               <td style="padding: 8px 0;">
                <table width="100%" cellpadding="0" cellspacing="0">
                 <tr>
                  <td style="font-size: 14px; color: #6b7280;">Grace Period Ends</td>
                  <td style="font-size: 16px; color: #dc2626; font-weight: 700; text-align: right;">
                   {{ $shopPlan->grace_ends_at->format('d M Y') }}
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
          <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 30px;">
           <tr>
            <td align="center">
             <a href="{{ route('renew') }}"
              style="display: inline-block; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #ffffff; text-decoration: none; padding: 16px 40px; border-radius: 10px; font-weight: 600; font-size: 16px; box-shadow: 0 4px 6px rgba(245, 158, 11, 0.3);">
              Renew Now &#8594;
             </a>
            </td>
           </tr>
          </table>

          <!-- What Happens Section -->
          <table width="100%" cellpadding="0" cellspacing="0"
           style="background-color: #fef2f2; border-radius: 12px; border-left: 4px solid #ef4444;">
           <tr>
            <td style="padding: 24px;">
             <h2 style="margin: 0 0 15px 0; font-size: 16px; color: #991b1b; font-weight: 600;">
              &#128680; What happens if you don't renew?
             </h2>
             <ul style="margin: 0; padding-left: 20px; color: #7f1d1d; font-size: 14px; line-height: 1.8;">
              <li>Your shop will be deactivated</li>
              <li>You won't be able to add new repairs</li>
              <li>Your employees will lose access</li>
              <li>Customers won't be able to track repairs</li>
             </ul>
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
        This is an automated reminder about your MobileShop subscription.
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
