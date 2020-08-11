<html>
    <head>

        <title>Verify Your Email</title>

    </head>
    <body>
        <div id="email_container" style="background:#0581c7">
            <div style="width:570px; padding:0 0 0 20px; margin:50px auto 12px auto" id="email_header">
                <span style="color:#fff;text-align: center;width: 100%;padding: 12px 0;display: block;font-size: 20px;">
                    Solarfeeds.com
                </div>
            </div>

            <div style="width:550px; padding:0 20px 20px 20px; background:#fff; margin:0 auto; border:3px #000 solid;
                moz-border-radius:5px; -webkit-border-radius:5px; border-radius:5px; color:#454545;line-height:1.5em; " id="email_content">

                <h1 style="padding:5px 0 0 0; font-family:georgia;font-weight:500;font-size:24px;color:#000;border-bottom:1px solid #bbb">
                    Verify Your Email
                </h1>
                <p style="text-align:center;padding: 20px 0;display: block;">
                <a style="background:#f14705;padding:10px 20px;color:#fff" href="https://shop.solarfeeds.com/review/?verify=yes&_email=<?php echo $email?>&_salt=<?php echo $hash ?>&id=<?php echo $review_id ?>">Verify Now</a>
                </p>
                <div style="text-align:center; border-top:1px solid #eee;padding:5px 0 0 0;" id="email_footer"> 
                    <small style="font-size:11px; color:#999; line-height:14px;">
                        You have received this email because you Submitted a review on solarfeeds.com
                    </small>
                </div>

            </div>
        </div>
    </body>
</html>