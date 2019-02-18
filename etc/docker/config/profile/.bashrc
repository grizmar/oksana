export HISTSIZE=10000
export HISTFILESIZE=10000
shopt -s histappend
PROMPT_COMMAND='history -a'
export HISTCONTROL=ignorespace:erasedups
export HISTIGNORE="ls:ps:history"
shopt -s cdspell

parse_git_branch() {
     git branch 2> /dev/null | sed -e '/^[^*]/d' -e 's/* \(.*\)/ [\1]/'
}
export PS1="\u \[\033[1;32m\]\w\[\033[0;31m\]\$(parse_git_branch)\[\033[00m\] $ "
