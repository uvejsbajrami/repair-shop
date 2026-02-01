<!DOCTYPE html>
<html>

<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>Application Received - MobileShop</title>
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
        <!-- Header -->
        <tr>
         <td style="background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); padding: 40px; text-align: center;">
          <div
           style="width: 80px; height: 80px; background-color: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto 20px; line-height: 80px;">
           <span style="font-size: 40px;">&#128232;</span>
          </div>
          <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 700;">
           Application Received!
          </h1>
          <p style="margin: 12px 0 0 0; color: rgba(255,255,255,0.9); font-size: 16px;">
           We've received your application for {{ $plan->name }}
          </p>
         </td>
        </tr>

        <!-- Content -->
        <tr>
         <td style="padding: 40px;">
          <!-- Greeting -->
          <p style="margin: 0 0 25px 0; font-size: 16px; color: #374151; line-height: 1.6;">
           Hi <strong>{{ $application->applicant_name }}</strong>,
          </p>
          <p style="margin: 0 0 30px 0; font-size: 16px; color: #374151; line-height: 1.6;">
           Thank you for submitting your application for the
           <strong>{{ $plan->name }}</strong> plan.
           Our team will review your application and get back to you shortly.
          </p>

          <!-- Status Badge -->
          <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 25px;">
           <tr>
            <td align="center">
             <span
              style="display: inline-block; background-color: #fef3c7; color: #92400e; padding: 10px 20px; border-radius: 20px; font-size: 14px; font-weight: 600;">
              &#9203; Application Status: Pending Review
             </span>
            </td>
           </tr>
          </table>

          <!-- Application Details Card -->
          <table width="100%" cellpadding="0" cellspacing="0"
           style="background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%); border-radius: 12px; margin-bottom: 25px;">
           <tr>
            <td style="padding: 24px;">
             <h2
              style="margin: 0 0 20px 0; font-size: 14px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">
              &#128203; Application Details
             </h2>
             <table width="100%" cellpadding="0" cellspacing="0">
              <!-- Shop Name -->
              <tr>
               <td style="padding: 10px 0;">
                <table cellpadding="0" cellspacing="0">
                 <tr>
                  <td
                   style="width: 40px; height: 40px; background-color: #2563eb; border-radius: 10px; text-align: center; vertical-align: middle;">
                   <span style="color: white; font-size: 18px;">&#127970;</span>
                  </td>
                  <td style="padding-left: 15px;">
                   <span
                    style="display: block; font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">Shop
                    Name</span>
                   <span
                    style="display: block; font-size: 16px; color: #1f2937; font-weight: 600;">{{ $application->shop_name }}</span>
                  </td>
                 </tr>
                </table>
               </td>
              </tr>

              <!-- Plan -->
              <tr>
               <td style="padding: 10px 0;">
                <table cellpadding="0" cellspacing="0">
                 <tr>
                  <td
                   style="width: 40px; height: 40px; background-color: #8b5cf6; border-radius: 10px; text-align: center; vertical-align: middle;">
                   <span style="color: white; font-size: 18px;">&#11088;</span>
                  </td>
                  <td style="padding-left: 15px;">
                   <span
                    style="display: block; font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">Selected
                    Plan</span>
                   <span
                    style="display: block; font-size: 16px; color: #1f2937; font-weight: 600;">{{ $plan->name }}</span>
                  </td>
                 </tr>
                </table>
               </td>
              </tr>

              <!-- Duration -->
              <tr>
               <td style="padding: 10px 0;">
                <table cellpadding="0" cellspacing="0">
                 <tr>
                  <td
                   style="width: 40px; height: 40px; background-color: #f59e0b; border-radius: 10px; text-align: center; vertical-align: middle;">
                   <span style="color: white; font-size: 18px;">&#128197;</span>
                  </td>
                  <td style="padding-left: 15px;">
                   <span
                    style="display: block; font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">Duration</span>
                   <span
                    style="display: block; font-size: 16px; color: #1f2937; font-weight: 600;">{{ $application->duration_months }}
                    {{ $application->duration_months === 1 ? 'Month' : 'Months' }}</span>
                  </td>
                 </tr>
                </table>
               </td>
              </tr>

              <!-- Email -->
              <tr>
               <td style="padding: 10px 0;">
                <table cellpadding="0" cellspacing="0">
                 <tr>
                  <td
                   style="width: 40px; height: 40px; background-color: #10b981; border-radius: 10px; text-align: center; vertical-align: middle;">
                   <span style="color: white; font-size: 18px;">&#128231;</span>
                  </td>
                  <td style="padding-left: 15px;">
                   <span
                    style="display: block; font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">Contact
                    Email</span>
                   <span
                    style="display: block; font-size: 16px; color: #1f2937; font-weight: 500;">{{ $application->applicant_email }}</span>
                  </td>
                 </tr>
                </table>
               </td>
              </tr>

              @if ($application->applicant_phone)
               <!-- Phone -->
               <tr>
                <td style="padding: 10px 0;">
                 <table cellpadding="0" cellspacing="0">
                  <tr>
                   <td
                    style="width: 40px; height: 40px; background-color: #ec4899; border-radius: 10px; text-align: center; vertical-align: middle;">
                    <span style="color: white; font-size: 18px;">&#128222;</span>
                   </td>
                   <td style="padding-left: 15px;">
                    <span
                     style="display: block; font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">Phone</span>
                    <span
                     style="display: block; font-size: 16px; color: #1f2937; font-weight: 500;">{{ $application->applicant_phone }}</span>
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

          <!-- What's Next Section -->
          <table width="100%" cellpadding="0" cellspacing="0"
           style="background-color: #f9fafb; border-radius: 12px; margin-bottom: 30px;">
           <tr>
            <td style="padding: 24px;">
             <h2 style="margin: 0 0 20px 0; font-size: 16px; color: #1f2937; font-weight: 600;">
              &#128161; What Happens Next?
             </h2>
             <table width="100%" cellpadding="0" cellspacing="0">
              <tr>
               <td style="padding: 10px 0;">
                <table cellpadding="0" cellspacing="0">
                 <tr>
                  <td
                   style="width: 30px; height: 30px; background-color: #dbeafe; border-radius: 50%; text-align: center; vertical-align: middle; font-weight: bold; color: #2563eb; font-size: 14px;">
                   1</td>
                  <td style="padding-left: 12px; font-size: 14px; color: #4b5563;">
                   Our team will review your application</td>
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
                  <td style="padding-left: 12px; font-size: 14px; color: #4b5563;">
                   You'll receive payment instructions via
                   email</td>
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
                  <td style="padding-left: 12px; font-size: 14px; color: #4b5563;">
                   Once approved, your shop will be activated
                  </td>
                 </tr>
                </table>
               </td>
              </tr>
             </table>
            </td>
           </tr>
           @if (Auth::id() === $application->user_id && $application->payment_status === 'awaiting_proof')
            <!-- Account Prompt -->
            <tr></tr>
            <td style="padding: 20px 0; text-align: center;">
             <p style="margin: 0; font-size: 14px; color: #6b7280; line-height: 1.6;">
              You can manage your application and view its status by logging
              into your account.
             </p>
             <a href="{{ route('plan.payment-proof.upload', $application->id) }}"
              style="display: inline-block; margin-top: 15px; padding: 12px 25px; background-color: #2563eb; color: #ffffff; text-decoration: none; border-radius: 8px; font-size: 14px; font-weight: 600;">
              Go to Payment Proof Upload
             </a>
           @endif
          </table>

          <!-- Note -->
          <table width="100%" cellpadding="0" cellspacing="0"
           style="background-color: #fef3c7; border-radius: 12px; border-left: 4px solid #f59e0b;">
           <tr>
            <td style="padding: 20px;">
             <p style="margin: 0; font-size: 14px; color: #92400e; line-height: 1.6;">
              <strong>&#128276; Note:</strong> If you have any questions about
              your application,
              feel free to reply to this email or contact our support team.
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
        Need help? Contact our support team anytime.
       </p>
       <p style="margin: 0 0 15px 0; font-size: 12px; color: #9ca3af;">
        You're receiving this email because you submitted an application on MobileShop.
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