<!DOCTYPE html>
<html>

<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>Application {{ $application->status === 'approved' ? 'Approved' : 'Update' }} - MobileShop</title>
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

        @if ($application->status === 'approved')
         <!-- APPROVED HEADER - Green Success Style -->
         <tr>
          <td style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 40px; text-align: center;">
           <div
            style="width: 80px; height: 80px; background-color: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto 20px; line-height: 80px;">
            <span style="font-size: 40px;">&#127881;</span>
           </div>
           <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 700;">
            Congratulations!
           </h1>
           <p style="margin: 12px 0 0 0; color: rgba(255,255,255,0.9); font-size: 16px;">
            Your application has been approved
           </p>
          </td>
         </tr>
        @else
         <!-- REJECTED HEADER - Red Danger Style -->
         <tr>
          <td style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); padding: 40px; text-align: center;">
           <div
            style="width: 80px; height: 80px; background-color: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto 20px; line-height: 80px;">
            <span style="font-size: 40px;">&#128532;</span>
           </div>
           <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 700;">
            Application Not Approved
           </h1>
           <p style="margin: 12px 0 0 0; color: rgba(255,255,255,0.9); font-size: 16px;">
            {{ $rejectionMessage }}
           </p>
          </td>
         </tr>
        @endif

        <!-- Content -->
        <tr>
         <td style="padding: 40px;">
          <!-- Greeting -->
          <p style="margin: 0 0 25px 0; font-size: 16px; color: #374151; line-height: 1.6;">
           Hi <strong>{{ $application->applicant_name }}</strong>,
          </p>

          @if ($application->status === 'approved')
           <!-- APPROVED Content -->
           <p style="margin: 0 0 30px 0; font-size: 16px; color: #374151; line-height: 1.6;">
            Great news! Your application for the <strong>{{ $plan->name }}</strong>
            plan has been approved.
            Your shop <strong>{{ $application->shop_name }}</strong> is now active
            and ready to use!
           </p>

           <!-- Success Badge -->
           <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 25px;">
            <tr>
             <td align="center">
              <span
               style="display: inline-block; background-color: #d1fae5; color: #065f46; padding: 10px 20px; border-radius: 20px; font-size: 14px; font-weight: 600;">
               &#9989; Application Status: Approved
              </span>
             </td>
            </tr>
           </table>

           <!-- Shop Details Card -->
           <table width="100%" cellpadding="0" cellspacing="0"
            style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border-radius: 12px; margin-bottom: 25px;">
            <tr>
             <td style="padding: 24px;">
              <h2
               style="margin: 0 0 20px 0; font-size: 14px; color: #065f46; text-transform: uppercase; letter-spacing: 0.5px;">
               &#127970; Your Shop Details
              </h2>
              <table width="100%" cellpadding="0" cellspacing="0">
               <tr>
                <td style="padding: 8px 0;">
                 <table width="100%" cellpadding="0" cellspacing="0">
                  <tr>
                   <td style="font-size: 14px; color: #6b7280;">
                    Shop Name</td>
                   <td style="font-size: 16px; color: #1f2937; font-weight: 600; text-align: right;">
                    {{ $application->shop_name }}
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
                    Plan</td>
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
                   <td style="font-size: 14px; color: #6b7280;">
                    Duration</td>
                   <td style="font-size: 16px; color: #1f2937; font-weight: 600; text-align: right;">
                    {{ $application->duration_months }}
                    {{ $application->duration_months === 1 ? 'Month' : 'Months' }}
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
                    Ends At</td>
                   <td style="font-size: 16px; color: #059669; font-weight: 700; text-align: right;">
                    {{ $planEndAt->format('d M Y') }}
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
                    Status</td>
                   <td style="font-size: 16px; color: #059669; font-weight: 700; text-align: right;">
                    Active
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
              <a href="{{ route('owner.dashboard') }}"
               style="display: inline-block; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; text-decoration: none; padding: 16px 40px; border-radius: 10px; font-weight: 600; font-size: 16px; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.3);">
               Go to Dashboard &#8594;
              </a>
             </td>
            </tr>
           </table>

           <!-- What's Next Section -->
           <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9fafb; border-radius: 12px;">
            <tr>
             <td style="padding: 24px;">
              <h2 style="margin: 0 0 20px 0; font-size: 16px; color: #1f2937; font-weight: 600;">
               &#128161; Get Started
              </h2>
              <table width="100%" cellpadding="0" cellspacing="0">
               <tr>
                <td style="padding: 10px 0;">
                 <table cellpadding="0" cellspacing="0">
                  <tr>
                   <td
                    style="width: 30px; height: 30px; background-color: #d1fae5; border-radius: 50%; text-align: center; vertical-align: middle; font-weight: bold; color: #059669; font-size: 14px;">
                    1</td>
                   <td style="padding-left: 12px; font-size: 14px; color: #4b5563;">
                    Log in to your dashboard</td>
                  </tr>
                 </table>
                </td>
               </tr>
               <tr>
                <td style="padding: 10px 0;">
                 <table cellpadding="0" cellspacing="0">
                  <tr>
                   <td
                    style="width: 30px; height: 30px; background-color: #d1fae5; border-radius: 50%; text-align: center; vertical-align: middle; font-weight: bold; color: #059669; font-size: 14px;">
                    2</td>
                   <td style="padding-left: 12px; font-size: 14px; color: #4b5563;">
                    Add your employees</td>
                  </tr>
                 </table>
                </td>
               </tr>
               <tr>
                <td style="padding: 10px 0;">
                 <table cellpadding="0" cellspacing="0">
                  <tr>
                   <td
                    style="width: 30px; height: 30px; background-color: #d1fae5; border-radius: 50%; text-align: center; vertical-align: middle; font-weight: bold; color: #059669; font-size: 14px;">
                    3</td>
                   <td style="padding-left: 12px; font-size: 14px; color: #4b5563;">
                    Start managing your repairs!</td>
                  </tr>
                 </table>
                </td>
               </tr>
              </table>
             </td>
            </tr>
           </table>
          @else
           <!-- REJECTED Content -->
           <p style="margin: 0 0 30px 0; font-size: 16px; color: #374151; line-height: 1.6;">
            We regret to inform you that your application for the
            <strong>{{ $plan->name }}</strong> plan
            has not been approved at this time.
           </p>

           <!-- Rejected Badge -->
           <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 25px;">
            <tr>
             <td align="center">
              <span
               style="display: inline-block; background-color: #fee2e2; color: #991b1b; padding: 10px 20px; border-radius: 20px; font-size: 14px; font-weight: 600;">
               &#10060; Application Status: Not Approved
              </span>
             </td>
            </tr>
           </table>

           <!-- Rejection Reason Card -->
           <table width="100%" cellpadding="0" cellspacing="0"
            style="background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%); border-radius: 12px; border-left: 4px solid #ef4444; margin-bottom: 25px;">
            <tr>
             <td style="padding: 24px;">
              <h2
               style="margin: 0 0 15px 0; font-size: 14px; color: #991b1b; text-transform: uppercase; letter-spacing: 0.5px;">
               &#128221; Reason
              </h2>
              <p style="margin: 0; font-size: 15px; color: #7f1d1d; line-height: 1.6;">
               @if ($application->payment_notes)
                {{ $application->payment_notes }}
               @else
                Your application did not meet our requirements at this
                time. This could be due to incomplete information,
                payment verification issues, or other factors.
               @endif
              </p>
             </td>
            </tr>
           </table>

           <!-- Application Details Card -->
           <table width="100%" cellpadding="0" cellspacing="0"
            style="background-color: #f9fafb; border-radius: 12px; margin-bottom: 25px;">
            <tr>
             <td style="padding: 24px;">
              <h2
               style="margin: 0 0 20px 0; font-size: 14px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">
               &#128203; Application Details
              </h2>
              <table width="100%" cellpadding="0" cellspacing="0">
               <tr>
                <td style="padding: 8px 0;">
                 <table width="100%" cellpadding="0" cellspacing="0">
                  <tr>
                   <td style="font-size: 14px; color: #6b7280;">
                    Shop Name</td>
                   <td style="font-size: 16px; color: #1f2937; font-weight: 600; text-align: right;">
                    {{ $application->shop_name }}
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
                    Requested Plan</td>
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
                   <td style="font-size: 14px; color: #6b7280;">
                    Duration</td>
                   <td style="font-size: 16px; color: #1f2937; font-weight: 600; text-align: right;">
                    {{ $application->duration_months }}
                    {{ $application->duration_months === 1 ? 'Month' : 'Months' }}
                   </td>
                  </tr>
                 </table>
                </td>
               </tr>
              </table>
             </td>
            </tr>
           </table>

           <!-- What You Can Do Section -->
           <table width="100%" cellpadding="0" cellspacing="0"
            style="background-color: #fffbeb; border-radius: 12px; border-left: 4px solid #f59e0b;">
            <tr>
             <td style="padding: 24px;">
              <h2 style="margin: 0 0 15px 0; font-size: 16px; color: #92400e; font-weight: 600;">
               &#128161; What You Can Do
              </h2>
              <ul style="margin: 0; padding-left: 20px; color: #78350f; font-size: 14px; line-height: 1.8;">
               <li>Review the reason above and address any issues</li>
               <li>Contact our support team for more details</li>
               <li>Submit a new application once issues are resolved</li>
              </ul>
             </td>
            </tr>
           </table>
          @endif
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
        You're receiving this email regarding your application on MobileShop.
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