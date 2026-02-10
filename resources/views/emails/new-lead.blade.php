<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Course Lead - SkillVedika</title>
</head>
<body style="margin:0; padding:0; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color:#f1f5f9; color:#0f172a;">

<!-- Main Container -->
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#f1f5f9; padding:30px 10px;">
    <tr>
        <td align="center">

            <!-- Card -->
            <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
                   style="max-width:680px; background:#ffffff; border-radius:16px; overflow:hidden; border:1px solid #e2e8f0; box-shadow:0 10px 30px rgba(0,0,0,0.08);">

                <!-- Header -->
                <tr>
                    <td style="background:#0b1f4b; padding:32px 40px 28px; text-align:center;">
                        <h1 style="margin:0; color:#ffffff; font-size:28px; font-weight:600; letter-spacing:-0.5px;">
                            New Course Lead Received
                        </h1>
                        <p style="margin:12px 0 0; color:rgba(255,255,255,0.85); font-size:15px;">
                            Lead ID #{{ $enrollment->id }}
                        </p>
                    </td>
                </tr>

                <!-- Content -->
                <tr>
                    <td style="padding:40px 40px 32px; font-size:15px; line-height:1.6; color:#0f172a;">

                        <!-- Basic Information -->
                        <h2 style="margin:0 0 20px; color:#0b1f4b; font-size:20px; font-weight:600;">
                            Basic Information
                        </h2>

                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
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
                        <h2 style="margin:36px 0 20px; color:#0b1f4b; font-size:20px; font-weight:600;">
                            Lead Source
                        </h2>
                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
                               style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px;">
                            <tr>
                                <td style="padding:14px 18px; font-size:15px; color:#0f172a;">
                                    {{
                                        $enrollment->meta['lead_source']
                                        ?? $enrollment->meta['page']
                                        ?? $enrollment->meta['source']
                                        ?? 'Unknown'
                                    }}
                                </td>
                            </tr>
                        </table>

                        <!-- Courses -->
                        <h2 style="margin:36px 0 20px; color:#0b1f4b; font-size:20px; font-weight:600;">
                            Interested Courses
                        </h2>
                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
                               style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px;">
                            <tr>
                                <td style="padding:14px 18px; font-size:15px; color:#0f172a;">
                                    @if(!empty($courseNames))
                                        {{ $courseNames }}
                                    @elseif(!empty($enrollment->courses))
                                        {{ implode(', ', $enrollment->courses) }}
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <!-- Message -->
                        @if(!empty($enrollment->message))
                            <h2 style="margin:36px 0 20px; color:#0b1f4b; font-size:20px; font-weight:600;">
                                Message from Lead
                            </h2>

                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
                                   style="background:#eff6ff; border-left:5px solid #1e40af; border-radius:10px;">
                                <tr>
                                    <td style="
                                        padding:20px 20px;
                                        font-size:15px;
                                        line-height:1.6;
                                        color:#0f172a;
                                        word-break:break-word;
                                        overflow-wrap:anywhere;
                                        white-space:normal;
                                    ">
                                        {{ $enrollment->message }}
                                    </td>
                                </tr>
                            </table>
                        @endif

                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background:#f1f5f9; padding:24px 40px; text-align:center; border-top:1px solid #e2e8f0; font-size:13px; color:#64748b;">
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

