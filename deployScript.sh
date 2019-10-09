#!/bin/bash

#Default values, will be shadow by environment
: ${DEST_DIR:="/var/www/html"}
#HARD default values
VERNUM="0.0.1"


#Display help
display_help ()
{
	echo "Usage : ${0} [OPTION ...]

Option :

	-h | --help		Display this message
	-v | --version		Display this script version
	   | --do-not-backup	Don't backup the latest deployment
"
}

#Display version
display_version ()
{
	echo "deployScript -- v${VERNUM} (pre-alpha)"
}

# Parsing options
while getopts ":hv-:*:" opt ; do
	case ${opt} in
		h )
			display_help
			exit 0;;
		v )
			display_version
			exit 0;;
		- ) case ${OPTARG} in
			help )
				display_help
				exit 0;;
			version )
				display_version
				exit 0;;
			do-not-backup )
				DONTBACK=1;;
			* )
				echo "Unrecognized option : --${OPTARG}"
				display_help
				exit 1;;
			esac ;;
		* )
			echo "Unrecognized option : ${opt}"
			display_help
			exit 1;;
	esac
done
shift $((${OPTIND}-1))

echo "Start deploying the newest version of the site"

# First we create a backup of the latest deployement

#TODO la suite
