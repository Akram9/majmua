import sys

exclude = [
    'youtube.com', 'twitter.com', 'facebook.com', 'instagram.com', 'apple.com',
    'google.com', 'vk.com', 'dropbox.com', 'cloudflare.com', 'youtu.be',
    'substack.com', 'wordpress.com', 'wp.com', 'pinterest.com', 'gmail.com',
    'medium.com', 'fb.com', 'tiny.cc', 'bit.ly', 'messenger.com', 'macromedia.com',
    'videojs.com', 'yahoo.com', 'hotmail.com', 'surveymonkey.com', 'soundcloud.com',
    'paypal.com', 'whatsapp.com', 'linkedin.com', 'tumblr.com', 'reddit.com',
    'telegram.com', 'telegram.me', 'wordpress.org', 'vimeo.com', 
]

domains = []

def check(line):
    for dom in exclude:
        if dom in line:
            return True
    return False

def unique(fil):
    with open(fil, 'r') as f:
        for line in f:
            line = line.rstrip('\n')
            if check(line):
                continue
            try:
                domain = line.split(' ')[1].split('/')[2]
                if domain not in domains:
                    domains.append(domain)
            except:
                pass
    
    return domains

def overwrite(fil, arr):
    try:
        with open(fil, 'w') as f:
            for i in arr:
                f.write(i + "\n")
    except Exception as e:
        print(e)

fil = sys.argv[1]
unidoms = unique(fil)
for i in unidoms:
    print(i)
print(len(unidoms))

overwrite(fil, unidoms)
