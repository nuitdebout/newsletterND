You need to have your SSH key added to the remote server.

Configure an alias and enable SSH Agent forwarding in `~/.ssh/config`

```
Host nuitdebout.fr
    Hostname XXX.XX.XX.XX
    User root
    ForwardAgent yes
```

Check if `ssh-agent` is running

```
ssh-add -L
```

If not, add your key to `ssh-agent`

```
ssh-add ~/.ssh/id_rsa.pub
```

Install `capistrano-symfony` Gem

```
gem capistrano-symfony
```

Deploy on production

```
cap production deploy
```