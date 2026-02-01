<!DOCTYPE html>
<html>

<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>You're Invited to Join {{ $shop->name }}</title>
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
           <span style="font-size: 40px;">&#128587;</span>
          </div>
          <h1 style="margin: 0; color: #ffffff; font-size: 28px; font-weight: 700;">
           You're Invited!
          </h1>
          <p style="margin: 12px 0 0 0; color: rgba(255,255,255,0.9); font-size: 16px;">
           Join {{ $shop->name }} as an employee
          </p>
         </td>
        </tr>

        <!-- Content -->
        <tr>
         <td style="padding: 40px;">
          <!-- Greeting -->
          <p style="margin: 0 0 25px 0; font-size: 16px; color: #374151; line-height: 1.6;">
           Hi <strong>{{ $user->name }}</strong>,
          </p>
          <p style="margin: 0 0 30px 0; font-size: 16px; color: #374151; line-height: 1.6;">
           You've been invited to join <strong>{{ $shop->name }}</strong> as an employee on MobileShop. As an employee,
           you'll be able to manage repair tickets and help customers track their device repairs.
          </p>

          <!-- Shop Details Card -->
          <table width="100%" cellpadding="0" cellspacing="0"
           style="background: linear-gradient(135deg, #eff6ff 0%, #f0f9ff 100%); border-radius: 12px; margin-bottom: 30px;">
           <tr>
            <td style="padding: 24px;">
             <h2
              style="margin: 0 0 20px 0; font-size: 14px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">
              &#127978; Shop Information
             </h2>
             <table width="100%" cellpadding="0" cellspacing="0">
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
                    style="display: block; font-size: 16px; color: #1f2937; font-weight: 600;">{{ $shop->name }}</span>
                  </td>
                 </tr>
                </table>
               </td>
              </tr>

              @if ($shop->address)
               <tr>
                <td style="padding: 10px 0;">
                 <table cellpadding="0" cellspacing="0">
                  <tr>
                   <td
                    style="width: 40px; height: 40px; background-color: #f59e0b; border-radius: 10px; text-align: center; vertical-align: middle;">
                    <span style="color: white; font-size: 18px;">&#128205;</span>
                   </td>
                   <td style="padding-left: 15px;">
                    <span
                     style="display: block; font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px;">Location</span>
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

          <!-- What You Can Do -->
          <table width="100%" cellpadding="0" cellspacing="0"
           style="background-color: #f9fafb; border-radius: 12px; margin-bottom: 30px;">
           <tr>
            <td style="padding: 24px;">
             <h2
              style="margin: 0 0 15px 0; font-size: 14px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">
              &#9989; As an employee, you can
             </h2>
             <table width="100%" cellpadding="0" cellspacing="0">
              <tr>
               <td style="padding: 8px 0; font-size: 14px; color: #374151;">
                <span style="color: #10b981; margin-right: 8px;">&#10003;</span>
                View all repairs for your shop
               </td>
              </tr>
              <tr>
               <td style="padding: 8px 0; font-size: 14px; color: #374151;">
                <span style="color: #10b981; margin-right: 8px;">&#10003;</span>
                Create new repair tickets
               </td>
              </tr>
              <tr>
               <td style="padding: 8px 0; font-size: 14px; color: #374151;">
                <span style="color: #10b981; margin-right: 8px;">&#10003;</span>
                Update repair status and details
               </td>
              </tr>
              <tr>
               <td style="padding: 8px 0; font-size: 14px; color: #374151;">
                <span style="color: #10b981; margin-right: 8px;">&#10003;</span>
                Help customers track their devices
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
             <p style="margin: 0 0 20px 0; font-size: 14px; color: #6b7280;">
              Click the button below to set up your password and activate your account:
             </p>
             <a href="{{ route('invitation.accept', ['token' => $token]) }}"
              style="display: inline-block; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; text-decoration: none; padding: 16px 40px; border-radius: 10px; font-weight: 600; font-size: 16px; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.3);">
              Accept Invitation &#8594;
             </a>
            </td>
           </tr>
          </table>

          <!-- Security Note -->
          <table width="100%" cellpadding="0" cellspacing="0"
           style="margin-top: 30px; background-color: #fef3c7; border-radius: 8px;">
           <tr>
            <td style="padding: 16px;">
             <p style="margin: 0; font-size: 13px; color: #92400e;">
              <strong>&#128274; Security Note:</strong> This invitation link is unique to you. Do not share it with
              anyone. If you didn't expect this invitation, please ignore this email.
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
        Need help? Contact the shop owner or our support team.
       </p>
       <p style="margin: 0 0 15px 0; font-size: 12px; color: #9ca3af;">
        You're receiving this email because you were invited to join {{ $shop->name }} on MobileShop.
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