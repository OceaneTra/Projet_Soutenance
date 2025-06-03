<?php



class MenuView {
    public function afficherMenu($traitements, $currentMenuSlug) {

         // Tri des traitements par ordre_traitement
         usort($traitements, function($a, $b) {
            return $a['ordre_traitement'] - $b['ordre_traitement'];
        });  
        // Génération du menu
        $html = '';
        foreach ($traitements as $traitement) {
            $isActive = ($currentMenuSlug === $traitement['lib_traitement']);
            $linkBaseClasses = "flex items-center px-2 py-3 text-sm font-medium rounded-md group";
            $activeClasses = "text-white bg-green-500";
            $inactiveClasses = "text-gray-700 hover:text-gray-900 hover:bg-gray-100";
            $iconBaseClasses = "mr-3";
            $iconActiveClasses = "text-white";
            $iconInactiveClasses = "text-gray-400 group-hover:text-gray-500";

            $html .= '<a href="?page=' . htmlspecialchars($traitement['lib_traitement']) . '" class="' . $linkBaseClasses . ' ' . ($isActive ? $activeClasses : $inactiveClasses) . '" >';
            $html .= '<i class="fas ' . htmlspecialchars($traitement['icone_traitement']) . ' ' . $iconBaseClasses . ' ' . ($isActive ? $iconActiveClasses : $iconInactiveClasses) . '"></i>';
            $html .= htmlspecialchars($traitement['label_traitement']);
            $html .= '</a>';
        }
        
        return $html;
    }
}