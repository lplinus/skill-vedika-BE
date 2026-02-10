<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Instructor Application - SkillVedika</title>
</head>
<body style="margin:0; padding:0; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color:#f1f5f9; color:#0f172a;">

<!-- Outer Wrapper -->
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#f1f5f9; padding:30px 10px;">
    <tr>
        <td align="center">

            <!-- Main Card -->
            <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
                   style="max-width:680px; background:#ffffff; border-radius:16px; overflow:hidden; border:1px solid #e2e8f0; box-shadow:0 10px 30px rgba(0,0,0,0.08);">

                <!-- Header -->
                <tr>
                    <td style="background:#1e3a8a; padding:32px 40px 28px; text-align:center;">
                        <h1 style="margin:0; color:#ffffff; font-size:28px; font-weight:600; letter-spacing:-0.5px;">
                            New Instructor Application
                        </h1>
                    </td>
                </tr>

                <!-- Content -->
                <tr>
                    <td style="padding:40px 40px 32px; font-size:15px; line-height:1.6; color:#0f172a;">

                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="160" style="padding:12px 0; color:#64748b; font-weight:500;">Name</td>
                                <td style="padding:12px 0; font-weight:600;">
                                    {{ $application->first_name }} {{ $application->last_name }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:12px 0; color:#64748b; font-weight:500;">Email</td>
                                <td style="padding:12px 0;">{{ $application->email }}</td>
                            </tr>
                            <tr>
                                <td style="padding:12px 0; color:#64748b; font-weight:500;">Phone</td>
                                <td style="padding:12px 0;">{{ $application->phone }}</td>
                            </tr>
                            <tr>
                                <td style="padding:12px 0; color:#64748b; font-weight:500;">Experience</td>
                                <td style="padding:12px 0;">
                                    {{ $application->years_of_experience }} year{{ $application->years_of_experience != 1 ? 's' : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:12px 0; color:#64748b; font-weight:500; vertical-align:top;">Skills</td>
                                <td style="padding:12px 0;">
                                    @if(!empty($application->skills))
                                        {{ implode(', ', $application->skills) }}
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                        </table>

                        @if(!empty($application->message))
                            <div style="margin-top:28px;">
                                <h3 style="margin:0 0 16px; color:#1e3a8a; font-size:18px; font-weight:600;">
                                    Message from Applicant
                                </h3>

                                <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
                                       style="background:#eff6ff; border-left:5px solid #1e3a8a; border-radius:10px;">
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
                                            {{ $application->message }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        @endif

                        <p style="margin:32px 0 0; font-size:13px; color:#64748b; text-align:center;">
                            Submitted at {{ $application->created_at->format('d M Y, h:i A') }}
                        </p>

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
