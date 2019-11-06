<?php 
/*! 
  @function num2letras () 
  @abstract Dado un n?mero lo devuelve escrito. 
  @param $num number - N?mero a convertir. 
  @param $fem bool - Forma femenina (true) o no (false). 
  @param $dec bool - Con decimales (true) o no (false). 
  @result string - Devuelve el n?mero escrito en letra. 

*/ 
function num2letras($num, $fem = false, $dec = true) { 
   $matuni[2]  = "dos"; 
   $matuni[3]  = "tres"; 
   $matuni[4]  = "cuatro"; 
   $matuni[5]  = "cinco"; 
   $matuni[6]  = "seis"; 
   $matuni[7]  = "siete"; 
   $matuni[8]  = "ocho"; 
   $matuni[9]  = "nueve"; 
   $matuni[10] = "Diez"; 
   $matuni[11] = "Once"; 
   $matuni[12] = "Doce"; 
   $matuni[13] = "Trece"; 
   $matuni[14] = "Catorce"; 
   $matuni[15] = "Quince"; 
   $matuni[16] = "Dieciseis"; 
   $matuni[17] = "Diecisiete"; 
   $matuni[18] = "Dieciocho"; 
   $matuni[19] = "Diecinueve"; 
   $matuni[20] = "Veinte"; 
   $matunisub[2] = "Dos"; 
   $matunisub[3] = "Tres"; 
   $matunisub[4] = "Cuatro"; 
   $matunisub[5] = "Quin"; 
   $matunisub[6] = "Seis"; 
   $matunisub[7] = "Sete"; 
   $matunisub[8] = "Ocho"; 
   $matunisub[9] = "Nove"; 

   $matdec[2] = "Veint"; 
   $matdec[3] = "Treinta"; 
   $matdec[4] = "Cuarenta"; 
   $matdec[5] = "Cincuenta"; 
   $matdec[6] = "Sesenta"; 
   $matdec[7] = "Setenta"; 
   $matdec[8] = "Ochenta"; 
   $matdec[9] = "Noventa"; 
   $matsub[3]  = 'Mill'; 
   $matsub[5]  = 'Bill'; 
   $matsub[7]  = 'Mill'; 
   $matsub[9]  = 'Trill'; 
   $matsub[11] = 'Mill'; 
   $matsub[13] = 'Bill'; 
   $matsub[15] = 'Mill'; 
   $matmil[4]  = 'Millones'; 
   $matmil[6]  = 'Billones'; 
   $matmil[7]  = 'De Billones'; 
   $matmil[8]  = 'Millones De billones'; 
   $matmil[10] = 'Trillones'; 
   $matmil[11] = 'De trillones'; 
   $matmil[12] = 'Millones De Trillones'; 
   $matmil[13] = 'De Trillones'; 
   $matmil[14] = 'Billones De Trillones'; 
   $matmil[15] = 'De Billones De Trillones'; 
   $matmil[16] = 'Millones De Billones De Trillones'; 
   
   //Zi hack
   $float=explode('.',$num);
   $num=$float[0];

   $num = trim((string)@$num); 
   if ($num[0] == '-') { 
      $neg = 'menos '; 
      $num = substr($num, 1); 
   }else 
      $neg = ''; 
   while ($num[0] == '0') $num = substr($num, 1); 
   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 
   $zeros = true; 
   $punt = false; 
   $ent = ''; 
   $fra = ''; 
   for ($c = 0; $c < strlen($num); $c++) { 
      $n = $num[$c]; 
      if (! (strpos(".,'''", $n) === false)) { 
         if ($punt) break; 
         else{ 
            $punt = true; 
            continue; 
         } 

      }elseif (! (strpos('0123456789', $n) === false)) { 
         if ($punt) { 
            if ($n != '0') $zeros = false; 
            $fra .= $n; 
         }else 

            $ent .= $n; 
      }else 

         break; 

   } 
   $ent = '     ' . $ent; 
   if ($dec and $fra and ! $zeros) { 
      $fin = ' coma'; 
      for ($n = 0; $n < strlen($fra); $n++) { 
         if (($s = $fra[$n]) == '0') 
            $fin .= ' cero'; 
         elseif ($s == '1') 
            $fin .= $fem ? ' una' : ' un'; 
         else 
            $fin .= ' ' . $matuni[$s]; 
      } 
   }else 
      $fin = ''; 
   if ((int)$ent === 0) return 'Cero ' . $fin; 
   $tex = ''; 
   $sub = 0; 
   $mils = 0; 
   $neutro = false; 
   while ( ($num = substr($ent, -3)) != '   ') { 
      $ent = substr($ent, 0, -3); 
      if (++$sub < 3 and $fem) { 
         $matuni[1] = 'una'; 
         $subcent = 'as'; 
      }else{ 
         $matuni[1] = $neutro ? 'un' : 'uno'; 
         $subcent = 'os'; 
      } 
      $t = ''; 
      $n2 = substr($num, 1); 
      if ($n2 == '00') { 
      }elseif ($n2 < 21) 
         $t = ' ' . $matuni[(int)$n2]; 
      elseif ($n2 < 30) { 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = 'i' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      }else{ 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = ' y ' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      } 
      $n = $num[0]; 
      if ($n == 1) { 
         $t = ' ciento' . $t; 
      }elseif ($n == 5){ 
         $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t; 
      }elseif ($n != 0){ 
         $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t; 
      } 
      if ($sub == 1) { 
      }elseif (! isset($matsub[$sub])) { 
         if ($num == 1) { 
            $t = ' mil'; 
         }elseif ($num > 1){ 
            $t .= ' mil'; 
         } 
      }elseif ($num == 1) { 
         $t .= ' ' . $matsub[$sub] . '?n'; 
      }elseif ($num > 1){ 
         $t .= ' ' . $matsub[$sub] . 'ones'; 
      }   
      if ($num == '000') $mils ++; 
      elseif ($mils != 0) { 
         if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
         $mils = 0; 
      } 
      $neutro = true; 
      $tex = $t . $tex; 
   } 
   $tex = $neg . substr($tex, 1) . $fin; 
   //Zi hack -->    return ucfirst($tex);
   //$end_num=ucfirst($tex).' pesos '.$float[1].'/100 M.N.';
   $end_num=$tex;
   return $end_num; 
} 
?> 