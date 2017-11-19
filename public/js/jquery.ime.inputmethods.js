( function ( $ ) {
	'use strict';

	$.extend( $.ime.sources, {
		
		'bn-avro': {
			name: 'Avro',
			source: 'rules/bn/bn-avro.js'
		},
		'bn-inscript': {
			name: 'ইন্‌স্ক্ৰিপ্ত',
			source: 'rules/bn/bn-inscript.js'
		},
		'bn-nkb': {
			name: 'National Keyboard',
			source: 'rules/bn/bn-nkb.js'
		},
		'bn-probhat': {
			name: 'Probhat',
			source: 'rules/bn/bn-probhat.js'
		},
		'ipa-sil': {
			name: 'International Phonetic Alphabet - SIL',
			source: 'rules/fonipa/ipa-sil.js'
		}
	} );

	$.extend( $.ime.languages, {
		
		'bn': {
			autonym: 'বাংলা',
			inputmethods: [ 'bn-avro', 'bn-inscript', 'bn-nkb', 'bn-probhat' ]
		},
		'en': {
			autonym: 'English',
			inputmethods: [ 'ipa-sil' ]
		}
	} );

}( jQuery ) );
