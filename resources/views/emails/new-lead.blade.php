{{-- <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Course Lead</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; background:#f9fafb; padding:20px;">

<div style="max-width:700px; margin:auto; background:#ffffff; border-radius:8px; border:1px solid #e5e7eb;">

    <!-- Header -->
    <div style="padding:16px 20px; border-bottom:1px solid #e5e7eb;">
        <h2 style="margin:0; color:#1A3F66;">New Course Lead Received</h2>
        <p style="margin:4px 0 0; color:#6b7280; font-size:13px;">
            Lead ID #{{ $enrollment->id }}
        </p>
    </div>

    <!-- Body -->
    <div style="padding:20px; font-size:14px;">

        <h4 style="color:#374151;">Basic Information</h4>

        <table width="100%" cellpadding="6" cellspacing="0">
            <tr>
                <td width="35%" style="color:#6b7280;">Name</td>
                <td><strong>{{ $enrollment->name }}</strong></td>
            </tr>
            <tr>
                <td style="color:#6b7280;">Email</td>
                <td>{{ $enrollment->email }}</td>
            </tr>
            <tr>
                <td style="color:#6b7280;">Phone</td>
                <td>{{ $enrollment->phone }}</td>
            </tr>
            <tr>
                <td style="color:#6b7280;">Status</td>
                <td>{{ $enrollment->status ?? 'New' }}</td>
            </tr>
            <tr>
                <td style="color:#6b7280;">Submitted At</td>
                <td>{{ $enrollment->created_at->format('d M Y, h:i A') }}</td>
            </tr>
        </table>

        <h4 style="margin-top:20px; color:#374151;">Lead Source</h4>
        <p>
            {{
                $enrollment->meta['lead_source']
                ?? $enrollment->meta['page']
                ?? $enrollment->meta['source']
                ?? 'Unknown'
            }}
        </p>

        <h4 style="margin-top:20px; color:#374151;">Courses</h4>
        <p>
            @if(!empty($enrollment->courses))
                {{ implode(', ', $enrollment->courses) }}
            @else
                —
            @endif
        </p>

        @if(!empty($enrollment->message))
            <h4 style="margin-top:20px; color:#374151;">Message from User</h4>
            <div style="padding:12px; background:#f3f4f6; border-left:4px solid #1A3F66;">
                {{ $enrollment->message }}
            </div>
        @endif

    </div>

    <div style="padding:14px 20px; background:#f9fafb; border-top:1px solid #e5e7eb; font-size:12px; color:#6b7280;">
        Automated notification from SkillVedika
    </div>

</div>
</body>
</html> --}}



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Course Lead - SkillVedika</title>
</head>
<body style="margin:0; padding:0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color:#f1f5f9; color:#1f2937;">

    <!-- Main Container -->
    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#f1f5f9; padding:30px 10px;">
        <tr>
            <td align="center">

                <!-- Card -->
                <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width:680px; background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.08); border:1px solid #e2e8f0;">

                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); padding:32px 40px 28px; text-align:center;">
                            <h1 style="margin:0; color:#ffffff; font-size:28px; font-weight:600; letter-spacing:-0.5px;">
                                New Course Lead Received
                            </h1>
                            <p style="margin:12px 0 0; color:rgba(255,255,255,0.9); font-size:15px; font-weight:400;">
                                Lead ID #{{ $enrollment->id }}
                            </p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:40px 40px 32px;">

                            <!-- Basic Information -->
                            <h2 style="margin:0 0 20px; color:#1e40af; font-size:20px; font-weight:600;">
                                Basic Information
                            </h2>

                            <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:15px; line-height:1.5; color:#374151;">
                                <tr>
                                    <td width="160" style="padding:10px 0; color:#64748b; font-weight:500;">Name</td>
                                    <td style="padding:10px 0; font-weight:600;">{{ $enrollment->name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 0; color:#64748b; font-weight:500;">Email</td>
                                    <td style="padding:10px 0;">{{ $enrollment->email }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 0; color:#64748b; font-weight:500;">Phone</td>
                                    <td style="padding:10px 0;">{{ $enrollment->phone }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 0; color:#64748b; font-weight:500;">Status</td>
                                    <td style="padding:10px 0;">
                                        <span style="background:#dcfce7; color:#166534; padding:4px 10px; border-radius:6px; font-size:13px; font-weight:500;">
                                            {{ $enrollment->status ?? 'New' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 0; color:#64748b; font-weight:500;">Submitted At</td>
                                    <td style="padding:10px 0;">{{ $enrollment->created_at->format('d M Y, h:i A') }}</td>
                                </tr>
                            </table>

                            <!-- Lead Source -->
                            <h2 style="margin:36px 0 20px; color:#1e40af; font-size:20px; font-weight:600;">
                                Lead Source
                            </h2>
                            <p style="margin:0; font-size:15px; color:#374151; background:#f8fafc; padding:14px 18px; border-radius:10px; border:1px solid #e2e8f0;">
                                {{
                                    $enrollment->meta['lead_source']
                                    ?? $enrollment->meta['page']
                                    ?? $enrollment->meta['source']
                                    ?? 'Unknown'
                                }}
                            </p>

                            <!-- Courses -->
                            <h2 style="margin:36px 0 20px; color:#1e40af; font-size:20px; font-weight:600;">
                                Interested Courses
                            </h2>
                            <p style="margin:0; font-size:15px; color:#374151; background:#f8fafc; padding:14px 18px; border-radius:10px; border:1px solid #e2e8f0;">
                                @if(!empty($courseNames))
                                    {{ $courseNames }}
                                @elseif(!empty($enrollment->courses))
                                    {{ implode(', ', $enrollment->courses) }}
                                @else
                                    —
                                @endif
                            </p>

                            <!-- Message -->
                            @if(!empty($enrollment->message))
                                <h2 style="margin:36px 0 20px; color:#1e40af; font-size:20px; font-weight:600;">
                                    Message from Lead
                                </h2>
                                <div style="background:#f8fafc; border-left:5px solid #3b82f6; padding:20px 24px; border-radius:10px; font-size:15px; line-height:1.6; color:#1e293b; white-space:pre-wrap;">
                                    {{ $enrollment->message }}
                                </div>
                            @endif

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f8fafc; padding:24px 40px; text-align:center; border-top:1px solid #e2e8f0; font-size:13px; color:#64748b;">
                            This is an automated notification from <strong>SkillVedika</strong><br>
                            <span style="color:#94a3b8;">{{ date('Y') }} © SkillVedika. All rights reserved.</span>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
