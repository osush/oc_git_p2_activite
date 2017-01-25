<?php

class monCrypteur 
{
    public function ecrireMdp($aUtil,$aMdp) 
    {
        $aChemin = 'mdp.txt';
        if(!file_exists($aChemin))
        {
            $id_File = fopen($aChemin, "w");
            fwrite($id_File, $aUtil.';'.$this->crypterMdp($aMdp).';'."\n");
            fclose($id_File);
        }
        else
        {
            if(($id_File = fopen($aChemin, "a+")))
            {
                $id_File = fopen($aChemin, "a+");
                flock($id_File, LOCK_EX);
                fwrite($id_File, $aUtil.';'.$this->crypterMdp($aMdp).';'."\n");
                flock($id_File, LOCK_UN);
                fclose($id_File);                
            }
            else
            {
                echo '<script>alert("Problème d\'ouverture")</script>';
            }
            
        }
    }
    
    public function verifierMdp($aUtil,$aMdp) 
    {
        $aMdpCrypt = $this->recupMdp($aUtil);
        if($aMdpCrypt)
        {
            if(crypt($aMdp,$aMdpCrypt) == $aMdpCrypt)
            {
                echo '<script>alert("Match")</script>';
            }
            else
            {
                echo '<script>alert("No Match")</script>';
            }
        }
        else
        {
            echo '<script>alert("Probleme de récupération")</script>';
        }
    }
    
    private function recupMdp($aUtil) 
    {
        $aChemin = 'mdp.txt';
        if(file_exists($aChemin))
        {
            $leTabNav = array();          
            if(($id_File = fopen($aChemin, "r")))
            {
                $id_File = fopen($aChemin, "r");
                flock($id_File, LOCK_EX);
                $monResult = false;
                while($leTabNav = fgetcsv($id_File,0,";"))
                {
                    if($aUtil == $leTabNav[0])
                    {                
                        $monResult = $leTabNav[1];
                    } 
                }                        
                flock($id_File, LOCK_UN);
                fclose($id_File);   
                if($monResult != false)
                {
                    return $monResult;
                }
                else
                {
                    echo '<script>alert("Pas d\'utilisateur de ce nom")</script>';
                    return false;
                } 
            }
            else
            {
                echo '<script>alert("Fichier n\'existe pas")</script>';
                return false;
            }
        }
    }
    
    private function crypterMdp($aMdp,$round = 9) 
    {
        $salt= '';
        $saltChar = array_merge(range('A', 'Z'),  range('a', 'z'),  range(0, 9));
        for($i=0;$i<22;$i++)
        {
            $salt .= $saltChar[array_rand($saltChar)];
        }
        return crypt($aMdp,  sprintf('$2y$%02d$',$round).$salt);
    }
}
