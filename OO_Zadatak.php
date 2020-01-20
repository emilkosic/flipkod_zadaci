<?php
define("PI", 3.14159);

class trokut
{
	private $tristranice_params;
	private $visina_params;
	private $povr;
	private $ops;
	
	// Konstruktor sa varijabilnim brojem argumenata (2 i 3 argumenta)
	public function __construct()
	{
		if(func_num_args() == 2 || func_num_args() == 3)
		{
			$args = func_get_args();
			foreach($args as $i) // Ako su argumenti negativni, pretvori u pozitivne
				if($i < 0) 
					$i = -$i;
			if(func_num_args() == 3) // Inicijalizacija trokuta s 3 stranice
			{
				if(!trokut::jetrokut($args[0], $args[1], $args[2]))
					return die("Zadane 3 stranice ne cine trokut!");
				$this->tristranice_params = array('a' => $args[0], 'b' => $args[1], 'c' => $args[2]);
				$this->povr = trokut::_povrsina($args[0], $args[1], $args[2]);
				$this->ops = $args[0] + $args[1] + $args[2];
			}
			else if(func_num_args() == 2) // Inicijalizacija trokuta s stranicom i visinom na nju
			{
				$visina_params = array('a' => $args[0], 'vis' => $args[1]);
				$this->povr = trokut::_povrsina($args[0], $args[1]);
			}
		}
		else // Ako nije 2 ni 3 argumenta, greska
			die("Krivi broj argumenata! (konstruktor trokut)");
	}
	// Provjera 3 stranice cine li trokut
	public static function jetrokut(float $a, float $b, float $c)
	{
		if(	($a + $b <= $c) ||
			($b + $c <= $a) ||
			($a + $c <= $b)
		)
			return false;
		else 
			return true;
	}
	
	// Ne-staticna izvedba metode povrsine
	public function povrsina()
	{
		if(isset($this) && isset($this->povr))
			return $this->povr;
		else
			die("Greska prilikom izracuna povrsine!");
	}
	
	public function opseg()
	{
		if(isset($this))
		{
			if(isset($this->ops))
				return $this->ops;
			else
				die("Nemoguce izracunati opseg! (premalo informacija)");
		}
		else
			die("Trokut nije pravilno zadan!");
	}
	
	// Staticna izvedba, javna zbog vise funkcionalnosti
	public static function _povrsina()
	{
		if(func_num_args() == 2 || func_num_args() == 3)
		{
			$args = func_get_args();
			if(func_num_args() == 2)
				return ($args[0] * $args[1] / 2);
			else if(func_num_args() == 3)
			{
				$s = ($args[0] + $args[1] + $args[2]) / 2;
				return sqrt($s * ($s - $args[0]) * ($s - $args[1]) * ($s - $args[2]));
			}
		}
		else
			die("Krivi broj argumenata! (metoda Povrsina)");
	}
}

class krug
{
	private $_rad;
	private $pov;
	private $ops;
	public function __construct(float $r)
	{
		$this->_rad = abs($r); // abs ako je unesena neg. vrij.
		$this->pov = ($r * $r * constant('PI'));
		$this->ops = (2 * $r * constant('PI'));
	}
	
	public function povrsina()
	{
		if(isset($this))
			return $this->pov;
	}
	
	public function opseg()
	{
		if(isset($this))
			return $this->ops;
	}
}

// Poziv metoda povrsine iz obje klase/objekta
$tr1 = new trokut(1, 2, 2.3);
echo "Tri stranice povrsina: ".$tr1->povrsina();
echo "Tri stranice opseg: ".$tr1->opseg();
$tr2 = new trokut(2,3,4.7);
echo "Stranica i visina povrsina: ".$tr2->povrsina();
echo "Stranica i visina opseg: ".$tr2->opseg();
$krug = new krug(3);
echo "Povrsina kruga: ".$krug->povrsina();
echo "Opseg kruga: ".$krug->opseg();
?>