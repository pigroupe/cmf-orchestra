#!/bin/bash
DIR=$1
PLATEFORM_INSTALL_NAME=$2
PLATEFORM_INSTALL_TYPE=$3
PLATEFORM_INSTALL_VERSION=$4
PLATEFORM_PROJET_NAME=$5
source $DIR/provisioners/shell/env.sh

echo "***** We set permmissions for all scriptshell"
sudo chmod -R 777 /tmp
sudo chmod -R +x $DIR
sudo chmod 755 /etc/apt/sources.list

echo "***** First we copy own sources.list to box *****"
if [ -f $DIR/provisioners/shell/etc/apt/$DISTRIB/sources.list ];
then
    cp $DIR/provisioners/shell/etc/apt/$DISTRIB/sources.list /etc/apt/sources.list
    apt-get -y update > /dev/null
    apt-get -y dist-upgrade > /dev/null
fi

echo "***** Second we update the system *****"
apt-get -y install build-essential > /dev/null
apt-get -y update > /dev/null
apt-get -y dist-upgrade > /dev/null

$DIR/provisioners/shell/SWAP/installer-swap.sh $DIR # important to allow the composer to have enough memory
$DIR/provisioners/shell/pc/installer-pc.sh $DIR $DISTRIB
$DIR/provisioners/shell/lemp/installer-lemp.sh $DIR
$DIR/provisioners/shell/plateform/installer-$PLATEFORM_INSTALL_NAME.sh $DIR $PLATEFORM_INSTALL_NAME $PLATEFORM_INSTALL_TYPE $PLATEFORM_INSTALL_VERSION $PLATEFORM_PROJET_NAME
$DIR/provisioners/shell/QA/installer-phpqatools.sh $DIR
#$DIR/provisioners/shell/jackrabbit/installer-jackrabbit-startup-script.sh $DIR
#if [ -f $DIR/provisioners/shell/solr/installer-solr-$DISTRIB.sh ];
#then
    #$DIR/provisioners/shell/solr/installer-solr-$DISTRIB.sh $DIR
#fi
#$DIR/provisioners/shell/nbi/installer-nbi.sh $DIR

echo "***** End we clean-up the system *****"
apt-get -y autoremove > /dev/null
apt-get -y clean > /dev/null
apt-get -y autoclean > /dev/null

echo "Finished provisioning."