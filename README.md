# Send "Whose Line is it Anyway" lines to a Slack workflow

## The show

**"Whose Line is it Anyway"** was initially an improvisation radio program that was aired in the BBC in the 80s.
It was quickly adapted to UK television on Channel 4 and a US version appeared in the late 90s, hosted by Drew Carey.
The US show was canceled in 2003 due to low ratings but a revival hosted by Aisha Tyler has been airing since 2013.
See the official [YouTube channel](https://www.youtube.com/channel/UCKg_ZFByYTINckLG76cjUEg) to watch excerpts from the show.

## Usage

This command randomly selects a line among a collection of lines from the **"Scenes from a Hat"** mini-game, where participants are required to improvise a funny scene inspired by the selected line, and posts it to a Slack web hook.
Lines are stored in the lines.yaml file, which you can update with your own lines if you wish.
Alternatively, you can also send a line of your choice by passing it as a command argument.

You will need to set up a Slack workflow containing a "line" variable for this to work, see [this page](https://slack.com/help/articles/360041352714-Create-more-advanced-workflows-using-webhooks) to learn how to do so.
Then you will need to set the `SLACK_URL` environment variable to post to the right workflow.

Run the command with `bin/console post-line [LINE]`. Leave the *LINE* argument empty to send a random line.
