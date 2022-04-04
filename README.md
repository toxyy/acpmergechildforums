# toxyy ACP Merge Child Forums v1.0.0

[Topic on phpBB.com](https://www.phpbb.com/community/viewtopic.php?t=2566181)

## Requirements

phpBB 3.3.x & PHP 7.1.3+

[![Build Status](https://travis-ci.org/toxyy/acpmergechildforums.svg?branch=master)](https://travis-ci.org/toxyy/acpmergechildforums)
## Features

Adds `short_number_ext` twig function

## Screenshot

Usage example: `{{ short_number_ext(forumrow.POSTS) }}`

![alt text](https://i.snipboard.io/tQVbdR.jpg)

## Quick Install

You can install this on the latest release of phpBB 3.3 by following the steps below:

* Create `toxyy/acpmergechildforums` in the `ext` directory.
* Download and unpack the repository into `ext/toxyy/acpmergechildforums`
* Enable `ACP Merge Child Forums` in the ACP at `Customise -> Manage extensions`.

## Uninstall

* Disable `ACP Merge Child Forums` in the ACP at `Customise -> Extension Management -> Extensions`.
* To permanently uninstall, click `Delete Data`. Optionally delete the `/ext/toxyy/acpmergechildforums` directory.

## Support

* Report bugs and other issues to the [Issue Tracker](https://github.com/toxyy/acpmergechildforums/issues).

## License

[GPL-2.0](license.txt)
