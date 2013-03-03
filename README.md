

RssMerger v0.7


What is it?
-----------
rssmerger is a python script which merges multiple RSS feeds into a single
feed while maintaining the correct order in which items appeared in the 
original feeds.


Requirements
------------
- Python 2.1+
- PyXML


Running
-------
When ran, rssmerger.py will read a number of RSS feeds (see below on how 
to specify RSS feeds) and output two RSS feeds; seen.rss and merged.rss.
merged.rss contains all merged items. seen.rss is used to keep an eye on
which items from each feed rssmerger has already merged into merged.rss.

rssmerger.py takes a couple of options:

-s, --silent        Silent. Do not report errors in RSS files
-q, --queries       Output all new RSS items as SQL queries
-i, --items ITEMS   Only keep ITEMS rss items in merged list
-v, --verbose       Be verbose
-h, --help          Show short help message (this)


Specifiying RSS feeds
---------------------
For now you'll have to specify your RSS feeds in the rssmerger.py source.
The feeds need to be specified as a dictionary. For each feed a key and a
URL should be given. The key shouldn't contain weird characters. Just use
A-Z.

Example:

rssUrls = {
	"osnews":"http://www.osnews.com/files/recent.rdf",
	"devchannel":"http://www.devchannel.org/index.rss",
	"kuro5hin":"http://www.kuro5hin.org/backend.rdf",
	"slashdot":"http://slashdot.org/index.rss",
}


RSS publisher element
---------------------
The key is needed so rssmerger knows from which feed the items came. It's 
also added to the merged.rss so you can determine in your rss feed reader
who published the item. The key is put in the feed as

  <rm:publisher>osnews</rm:publisher>

The "rm" namespace is defined as: 

  http://localhost/rssmerger/

You can use the rm:publisher element in your feed reader and show an icon
for it or something.

Database queries
----------------

If you want RssMerger to add new items to a database, you can use the --queries
option. This will output a query for each new item found. You can call
RssMerger with this option from a shellscript which puts the queries in a
database.

The database structure can be found in rssmerger.sql. A sample script looks 
like this (MySQL):

  ----- CUT HERE -- 8< ------------------------------------------------------
  #!/bin/sh
  
  rssmerger.py --queries  | mysql -u todsah -ppassword -h dbhost rssmerger
  ----- CUT HERE -- 8< ------------------------------------------------------

Please note that RssMerger outputs queries in the ASCII encoding which causes
special characters (for instance, with accents) to be replaced with a '?'. There
is no other way of handling this because the queries are written to stdout and
we can't assume it supports anything other than ASCII.

Sample feed reader
------------------
A sample feed reader written in PHP is included in this archive. It makes use
of the special options offered by rssmerger.py like the <rm:publisher> element.


Copyright
---------
Copyright (c) 2003-2007, Ferry Boender <f DOT boender AT electricmonk DOT nl>
Licensed under the General Public License (GPL), see COPYING file 
provided with this program.


Author
------

Ferry Boender <f DOT boender AT electricmonk DOT nl>
http://www.electricmonk.nl


Credits
-------

Bastiaan Schenk - Query suggestion & testing.
Jeroen Leijen - Bug reports.
