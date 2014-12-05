<?php

	function jib_word($length) {//Returns random jiberish Word
		$vowels = array("a", "e", "i", "o", "u");
		$cons = array("b", "c", "d", "g", "h", "j", "k", "l", "m", "n", "p", "r", "s", "t", "v", "w");#, "tr", "cr", "br", "fr", "th", "dr", "ch", "ph", "wr", "st", "sp", "sw", "pr", "sl", "cl", "sh"

		$num_vowels = count($vowels);
		$num_cons = count($cons);
		$word = '';

		while (strlen($word) < $length) {
		$word .= $cons[mt_rand(0, $num_cons - 1)] . $vowels[mt_rand(0, $num_vowels - 1)];
		}

		return substr($word, 0, $length);
	}
	function jib_sentence($num_words, $min_length, $max_length){
		$words = '';
		for($i = 0; $i < $num_words; $i++){
			$words.=jib_word(mt_rand($min_length,$max_length)).' ';
		}
		return $words;
	}

	function rand_animal(){//returns random Animal
		$list = array ('aardvark', 'alligator', 'alpaca', 'anteater', 'antelope', 'ape', 'armadillo', 'baboon', 'badger', 'basilisk', 'bat', 'bear', 'beaver', 'bighorn', 'bison', 'boar', 'buffalo', 'bull', 'bunny', 'burro', 'camel', 'canary', 'capybara', 'cat', 'chameleon', 'cheetah', 'chimpanzee', 'chinchilla', 'chipmunk', 'civet', 'colt', 'cony', 'cougar', 'cow', 'coyote', 'crocodile', 'crow', 'deer', 'dingo', 'doe', 'dog', 'donkey', 'dormouse', 'duckbill', 'elephant', 'elk', 'ermine', 'fawn', 'ferret', 'finch', 'fish', 'fox', 'frog', 'gazelle', 'giraffe', 'gnu', 'goat', 'gopher', 'gorilla', 'grizzly', 'groundhog', 'hamster', 'hare', 'hedgehog', 'hippo', 'hog', 'horse', 'hyena', 'iguana', 'jackal', 'jaguar', 'kangaroo', 'koala', 'koodoo', 'lamb', 'lemur', 'leopard', 'lion', 'lizard', 'llama', 'lynx', 'mandrill', 'mare', 'marmoset', 'mink', 'mole', 'mongoose', 'monkey', 'moose', 'mouse', 'mule', 'musk-ox', 'muskrat', 'mustang', 'okapi', 'opossum', 'orangutan', 'oryx', 'otter', 'ox', 'panda', 'panther', 'parakeet', 'parrot', 'pig', 'platypus', 'polarbear', 'pony', 'porcupine', 'porpoise', 'puma', 'puppy', 'rabbit', 'raccoon', 'ram', 'rat', 'reindeer', 'reptile', 'rhino', 'salamander', 'seal', 'sheep', 'shrew', 'fox', 'skunk', 'sloth', 'snake', 'springbok', 'squirrel', 'stallion', 'tiger', 'toad', 'turtle', 'walrus', 'warthog', 'weasel', 'wildcat', 'wolf', 'wolverine', 'wombat', 'woodchuck', 'yak', 'zebra');
		$i = count($list);
		return $list[mt_rand(0,$i-1)];
	}
	function rand_prefix(){//returns Random prefix word
		$list = array ('abiding', 'anxious', 'automatic', 'brave', 'coordinated', 'direful', 'empty', 'enormous', 'fierce', 'fortunate', 'frantic', 'fretful', 'frightening', 'imminent', 'juicy', 'mundane', 'overrated', 'panicky', 'perpetual', 'quizzical', 'rabid', 'ruthless', 'standing', 'tidy', 'useless', 'utopian', 'adroit', 'advantageous', 'adventurous', 'advisable', 'aware', 'beneficial', 'canny', 'careful', 'cautious', 'civil', 'considerate', 'convenient', 'courteous', 'deft', 'delicate', 'diplomatic', 'discerning', 'discreet', 'effective', 'far-sighted', 'feasible', 'fit', 'fitting', 'frugal', 'gentle', 'helpful', 'judgmatic', 'judicious', 'leery', 'observant', 'opportune', 'perceptive', 'poised', 'polished', 'polite', 'politic', 'possible', 'practicable', 'practical', 'pragmatic', 'profitable', 'proper', 'provident', 'prudent', 'reasonable', 'sage', 'sane', 'sapient', 'sensitive', 'shrewd', 'skilled', 'skillful', 'sound', 'sparing', 'suave', 'subtle', 'suitable', 'sympathetic', 'tactical', 'thrifty', 'timely', 'understanding', 'urbane', 'useful', 'utilitarian', 'vigilant', 'wary', 'wise');
		$i = count($list);
		return $list[mt_rand(0,$i-1)];
	}
	function rand_warrior(){//returns Random warrior word
		$list = array ('adversary', 'advocate', 'ally', 'antagonist', 'apache', 'assailant', 'attacker', 'backer', 'barbarian', 'battler', 'belligerent', 'centurion', 'challenger', 'champ', 'combatant', 'commando', 'conqueror', 'contender', 'contester', 'corsair', 'crusader', 'defender', 'disputant', 'enemy', 'entrant', 'expounder', 'foe', 'gladiator', 'goliath', 'guardian', 'gurkha', 'hero', 'horseman', 'immortal', 'knight', 'legionairre', 'marshall', 'medalist', 'mongol', 'musketeer', 'ninja', 'partisan', 'patron', 'pirate', 'player', 'proponent', 'protector', 'ranger', 'rifler', 'rival', 'rover', 'samurai', 'scrapper', 'serviceman', 'soldier', 'spartan', 'spoiler', 'upholder', 'vanquisher', 'victor', 'viking', 'vindicator', 'warrior', 'winner');
		$i = count($list);
		return $list[mt_rand(0,$i-1)];
	}

	function rand_color(){//returns Random color string
		$list = array ('azure', 'amber','black', 'blue', 'cobalt', 'copper', 'bronze', 'tan', 'crimson', 'dark', 'brown', 'desert', 'emerald', 'foliage', 'gold', 'green', 'indigo', 'ivory', 'navy', 'olive', 'onyx', 'orange', 'pink', 'platinum', 'red', 'rose', 'ruby', 'sapphire', 'slate', 'silver', 'smoke', 'turquoise', 'violet', 'yellow');
		$i = count($list);
		return $list[mt_rand(0,$i-1)];
	}

	function rand_blade(){//returns Random blade type
		$list = array ('blade', 'broadsword', 'claymore', 'dao', 'gladius', 'katana', 'longsword', 'odachi', 'rapier', 'sabre', 'shortsword', 'sword', 'wakazashi');
		$i = count($list);
		return $list[mt_rand(0,$i-1)];
	}
	function UPC() {
		$odd_sum = $even_sum = 0;

		for ($i = 1; $i < 12; $i++) {
			$digits[$i] = rand(0,9);
			if($i % 2 == 0) $even_sum += $digits[$i];
			else $odd_sum += $digits[$i];
		}
		$digits[$i] = 10 - ((3 * $odd_sum + $even_sum) % 10);
		return implode('',$digits);
	}
	function bacon_ipsum($sen =1){
		$text = '';
		$api_get = file_get_contents('http://baconipsum.com/api/?type=all-meat&paras='.$sen.'&start-with-lorem=1');
		$jsonobj  = json_decode($api_get);
		foreach ($jsonobj as $key => $value) {
		 	$text .= $value;
		 } 
		return $text;	 
	}

?>