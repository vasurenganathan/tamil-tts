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
import pprint
import operator
from ngram.LetterModels import Unigram, Bigram, Trigram
from ngram.WordModels import get_ngram_groups

sys.stdout = codecs.getwriter('utf-8')(sys.stdout)

class TamilVUNgram:
    def __init__(self):
        self.filename = u'tamilvu_dictionary_words.txt'
        self.unigram = Unigram(self.filename)
        self.unigram.frequency_model()
        print(u"--- completed Unigram model ---")
        self.bigram = Bigram(self.filename)
        self.bigram.language_model(verbose=False)
        self.trigram = Trigram(self.filename)
        self.trigram.language_model(verbose=False)
        
        print(u"--- completed Bigram,Trigram model ---")
        
    def save(self):
        # save letter2 of bigram
        # save letter of unigram
        with codecs.open("tvu_bigram.txt","w","utf-8") as fp:
            d = {}
            for k,v in self.bigram.letter2.items():
                for k2,v2 in v.items():
                    if v2 == 0:
                        continue
                    d[k+k2] = v2
            for k,v in sorted(d.items(),key=operator.itemgetter(1),reverse=True):
                fp.write(u"%s - %d\n"%(k,v))
            
        with codecs.open("tvu_unigram.txt","w","utf-8") as fp:
            for k,v in sorted(self.unigram.letter.items(),key=operator.itemgetter(1),reverse=True):
                if v == 0:
                    continue
                fp.write(u"%s - %d\n"%(k,v))
        self.trigram.save(u'tvu_trigram.txt')
        print(u"SAVED tvu_unigram.txt, tvu_bigram.txt")
        
if __name__ == u"__main__":
    tamildict = TamilVUNgram()
    tamildict.save()
