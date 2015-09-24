#!/bin/bash

set -x

## Move .ssh to avoid exposure
if [ -d $HOME/htdocs/.ssh ]; then
    mv $HOME/htdocs/.ssh $HOME/
    ## And fix access rights
    chmod 700 $HOME/.ssh
    chmod 600 $HOME/.ssh/*
fi

## Evacuate deployed data files
datadir=$HOME/htdocs/data
savedir=$HOME/tmp/data
mkdir -p $savedir
mv $datadir/* $savedir/

## Unmount $datadir beforehand
fusermount -u $datadir

## Mount remote directory via sshfs
sshfs ${SSH_HOST}:${SSH_PATH} $datadir \
    -C \
    -o IdentityFile=$HOME/.ssh/${SSH_KEY_NAME} \
    -o StrictHostKeyChecking=yes \
    -o UserKnownHostsFile=$HOME/.ssh/known_hosts \
    -o idmap=user \
    -o cache=yes \
    -o kernel_cache \
    -o compression=no \
    -o large_read \
    -o Ciphers=arcfour

## Change access rights
chmod -R a+rwX $datadir

## Write back datafile(s) if they does not exist in mounted directory
for distfile in $savedir/*; do
    fname=$(basename $distfile)
    if [ ! -e $datadir/$fname ]; then
	cp $distfile $datadir/
    fi
done
