import sys
import smtplib
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText

# skip first entry of array since that's the name of the file

args = sys.argv[1:]


class Main:
    @staticmethod
    def mail():
        # ghetto argument binding
        toAddr = args[0]
        subject = args[1]
        body = args[2]
        fromAddr = args[3]
        pwd = args[4]

        # setup email data
        msg = MIMEMultipart()
        msg['From'] = fromAddr
        msg['To'] = toAddr
        msg['Subject'] = subject
        msg['body'] = body
        msg.attach(MIMEText(body, 'html'))
        text = msg.as_string()

        # start stmp server and send mail afterwards shutting down the stmp server (yes this is inefficient with
        # large batches of email i am aware)
        server = smtplib.SMTP('smtp.gmail.com', 587)
        server.starttls()
        server.login(fromAddr, pwd)
        server.sendmail(fromAddr, toAddr, text)

        server.quit()

if __name__ == '__main__':
    mail = Main()
    Main.mail()
    pass
