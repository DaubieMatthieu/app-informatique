#!/bin/bash

do_backup()
{
  if [ ! -d ${1}] ; then
    mkdir -p ${1}
  fi

  cp -r ${2} ${1}
}

do_void_deployed()
{
  rm -rf ${1}
}
