#!/usr/bin/python
# (C) 2015 Muthiah Annamalai, <ezhillang@gmail.com>
#     Ezhil Language Foundation
#     
from __future__ import print_function
import sys
import codecs
import tamil
import json
import os

sys.stdout = codecs.getwriter('utf-8')(sys.stdout)

class WordList:
    @staticmethod
    def extract_words(filename):
        ht = json.load( codecs.open(filename,'r','utf-8') )
        for word in sorted(ht.keys()):
            print(word)
        return
    
    @staticmethod
    def pull_words_from_json():
        for itr in range(1,25):
            filename = u"v%02d.json"%itr
            WordList.extract_words(filename)
        return

class TamilDictionary:
    def __init__(self):
        filename = u'tamilvu_dictionary_words.txt'
        with codecs.open(filename,'r','utf-8') as fp:
            self.tadict = fp.readlines()
    def data(self):
        return self.tadict

class WordFilter:
    #non-zero mode when True will enable files for non-zero matches only
    @staticmethod
    def filter_and_save(word_size,tadict,nzmode=True):
        match_word_length = lambda word: len(tamil.utf8.get_letters(word.strip().replace(' ',''))) == word_size
        matches = filter( match_word_length, tadict)
        outfile = 'word_filter_%02d.txt'%word_size
        with codecs.open(outfile,'w','utf-8') as fp:
            for word in matches:
                fp.write(u'%s\n'%word.replace(' ','').strip())
        if len(matches) < 1 and nzmode:
            print(u'no words of length %d\n'%word_size)
            os.unlink(outfile)
        else:
            print(u'we found  %d words of length %d\n'%(len(matches),word_size))
        return

if __name__ == u"__main__":
    # WordList.pull_words_from_json()
    tamildict = TamilDictionary()
    for wlen in range(1,35):
        WordFilter.filter_and_save( wlen, tamildict.data() )
