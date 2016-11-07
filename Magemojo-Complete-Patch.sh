#!/bin/bash

function formkey {
  FILELIST=""
  FILENAME=$1
  SEARCH=$2
  DRY=$3
  for FILE in $(find app/design/frontend/ -name $FILENAME); do
    if [[ $FILE != "app/design/frontend/base"* ]]
    then
      STRINGSEARCH=`grep -n $SEARCH $FILE | cut -d : -f1 | tr "\n" " " | tr -d "\r"`
      if [ ! -z $STRINGSEARCH ]
      then
        #check if formkey already exists
        FORMKEY=`grep -n '<?php echo $this->getBlockHtml('"'"'formkey'"'"'); ?>' $FILE | cut -d : -f1 | tr "\n" " " | tr -d "\r"`
        if [ ! -z $FORMKEY ]
        then
          if [ $DRY == "N" ]
          then
            ADD=1
            for LINENUM in $SEARCHSTRING
            do
              #echo $LINENUM
              LINENUM=$((LINENUM+$ADD))
              INSERT=$LINENUM"i<?php echo $this->getBlockHtml(\'formkey\'); ?>"
              sed -i "$INSERT" $FILE
              ADD=$(($ADD+1))
            done
          fi
          FILELIST="$FILELIST $FILE"
        fi
      fi
    fi
  done
  echo $FILELIST
}

if [ ! -z "$1" ]
then
  if [ $1 == "dryrun" ]
  then
    DRYRUN=1
  else
    DRYRUN=0
  fi
else
  DRYRUN=0
fi

echo 'Detecting Magento Version'
VERSION=`php -r "require \"./app/Mage.php\"; echo Mage::getVersion(); "`
EDITION=`php -r "require \"./app/Mage.php\"; echo Mage::getEdition(); "`
if [ -z $VERSION ] || [ -z $EDITION ]
then
  echo "Failed to determine Magento Version exiting"
  exit
fi
echo "Version $EDITION $VERSION"
EDITION=`echo "$EDITION" | awk '{print tolower($0)}'`
echo "Requesting patch file..."
if [ -e $EDITION-$VERSION-patch.tar.gz ]
then
  rm -rf $EDITION-$VERSION-patch.tar.gz
fi
wget --quiet http://magemojo.com/files/magento_versions/$EDITION-$VERSION-patch.tar.gz
if [ ! -e $EDITION-$VERSION-patch.tar.gz ]
then
  echo "Failed to download patch file, version may not be available"
  exit
fi
echo "Creating manifest of patched core files"
PATCHLIST=`tar -tzf $EDITION-$VERSION-patch.tar.gz`
echo "Creating manifest of template files that were ommited by standard patches"

#view.phtml
SEARCH='$this->getSubmitUrl($_product)'
RESULTS=`formkey view.phtml $SEARCH Y`
TEMPLATELIST="$TEMPLATELIST $RESULTS"

#cart.phtml
SEARCH='$this->getUrl('"'"'checkout/cart/updatePost'"'"')'
RESULTS=`formkey cart.phtml $SEARCH Y`
TEMPLATELIST="$TEMPLATELIST $RESULTS"

#login.phtml
SEARCH='$this->getPostActionUrl()'
RESULTS=`formkey login.phtml $SEARCH Y`
TEMPLATELIST="$TEMPLATELIST $RESULTS"

#form.phtml
SEARCH='<form action="<?php echo $this->getAction() ?>" method="post" id="review-form">'
RESULTS=`formkey form.phtml $SEARCH Y`
TEMPLATELIST="$TEMPLATELIST $RESULTS"

#sidebar.phtml
SEARCH='<form method="post" action="<?php echo $this->getFormActionUrl() ?>" id="reorder-validate-detail">'
RESULTS=`formkey sidebar.phtml $SEARCH Y`
TEMPLATELIST="$TEMPLATELIST $RESULTS"

#register.phtml
SEARCH='$this->getPostActionUrl()'
RESULTS=`formkey register.phtml $SEARCH Y`
TEMPLATELIST="$TEMPLATELIST $RESULTS"

DELETELIST="./skin/adminhtml/default/default/media/flex.swf ./skin/adminhtml/default/default/media/uploader.swf ./skin/adminhtml/default/default/media/uploaderSingle.swf"

BACKUPLIST="$PATCHLIST $TEMPLATELIST $DELETELIST"

NOW=$(date +"%s")
BACKUPNAME="patch-backup-$NOW.tar.gz"
echo "Creating backup tar...."
tar -zcf $BACKUPNAME $BACKUPLIST > /dev/null 2>&1
echo "$BACKUPNAME created"

if [ $DRYRUN -eq 1 ]
then
  echo "Dryrun files that would be modified...."
  for FILE in $BACKUPLIST ; do
    echo $FILE
  done
else
  echo "Patching files...."
  echo "Updating core...."
  tar -zxf $EDITION-$VERSION-patch.tar.gz
  echo "Core updated"
  
  echo "Updating custom template form keys..."  
  #view.phtml
  SEARCH='$this->getSubmitUrl($_product)'
  RESULTS=`formkey view.phtml $SEARCH Y`
  TEMPLATELIST="$TEMPLATELIST $RESULTS"

  #cart.phtml
  SEARCH='$this->getUrl('"'"'checkout/cart/updatePost'"'"')'
  RESULTS=`formkey cart.phtml $SEARCH Y`
  TEMPLATELIST="$TEMPLATELIST $RESULTS"

  #login.phtml
  SEARCH='$this->getPostActionUrl()'
  RESULTS=`formkey login.phtml $SEARCH Y`
  TEMPLATELIST="$TEMPLATELIST $RESULTS"

  #form.phtml
  SEARCH='<form action="<?php echo $this->getAction() ?>" method="post" id="review-form">'
  RESULTS=`formkey form.phtml $SEARCH Y`
  TEMPLATELIST="$TEMPLATELIST $RESULTS"

  #sidebar.phtml
  SEARCH='<form method="post" action="<?php echo $this->getFormActionUrl() ?>" id="reorder-validate-detail">'
  RESULTS=`formkey sidebar.phtml $SEARCH Y`
  TEMPLATELIST="$TEMPLATELIST $RESULTS"

  #register.phtml
  SEARCH='$this->getPostActionUrl()'
  RESULTS=`formkey register.phtml $SEARCH Y`
  TEMPLATELIST="$TEMPLATELIST $RESULTS"

  echo "Templates updated"

  echo "Removing vulnerable files...."
    for FILE in $DELETELIST ; do
    rm -rf $FILE
  done
  echo "Vulnerable files removed"

  echo "PATCHING COMPLETE!"
  #echo "REMEMBER TO CLEAR YOUR CACHES!"
fi
