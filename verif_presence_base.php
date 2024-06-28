<?php
// Fonction pour vérifier les doublons dans une liste et mettre les last_name en majuscules
function processPeople( $people ) {
    $uniquePeople = [];
    $processedPeople = [];
    $duplicates = [];
    $allPeople = [];

    foreach ( $people as $person ) {
        $person[ 'last_name' ] = strtoupper( $person[ 'last_name' ] );
        $fullName = $person[ 'first_name' ] . ' ' . $person[ 'last_name' ];

        if ( !in_array( $fullName, $allPeople ) ) {
            $allPeople[] = $fullName;
            $uniquePeople[] = $fullName;
            $processedPeople[] = $person;
        } else {
            if ( !in_array( $fullName, $duplicates ) ) {
                $duplicates[] = $fullName;
            }
        }
    }

    return [ 'processedPeople' => $processedPeople, 'duplicates' => $duplicates ];
}

$people = [
    [ "first_name" => "Christophe Etienne", "last_name" => "ADAM" ],
    [ "first_name" => "Marie-Françoise Catherine", "last_name" => "ADAM" ],
    [ "first_name" => "Pierre-François", "last_name" => "ALLIX" ],
    [ "first_name" => "Rose-Françoise", "last_name" => "ALLIX" ],
    [ "first_name" => "Augustine Alexandrine", "last_name" => "AMIOT" ],
    [ "first_name" => "Félix", "last_name" => "AMIOT" ],
    [ "first_name" => "Jean Charles Felix", "last_name" => "AMIOT" ],
    [ "first_name" => "Rosalie Josephine Julie", "last_name" => "ANDRÉ" ],
    [ "first_name" => "Rose Joséphine", "last_name" => "ARDISSON" ],
    [ "first_name" => "Geneviève", "last_name" => "AUVRAY" ],
    [ "first_name" => "Marguerite", "last_name" => "AUZIÉ" ],
    [ "first_name" => "Marie Suzanne Françoise", "last_name" => "AVENARD" ],
    [ "first_name" => "Jean Georges Michel", "last_name" => "BASNIER" ],
    [ "first_name" => "Julie Justine", "last_name" => "BASNIER" ],
    [ "first_name" => "Augustin", "last_name" => "BELLIOT" ],
    [ "first_name" => "Jacques Nicolas", "last_name" => "BENOIST" ],
    [ "first_name" => "Marie Justine", "last_name" => "BENOIST" ],
    [ "first_name" => "Nicolas", "last_name" => "BENOIST" ],
    [ "first_name" => "Alexandre", "last_name" => "BENOIT" ],
    [ "first_name" => "Armand Joseph", "last_name" => "BENOIT" ],
    [ "first_name" => "Pierre Alexandre", "last_name" => "BENOIT" ],
    [ "first_name" => "Thomas Marie", "last_name" => "BENOIT" ],
    [ "first_name" => "Joseph-Alban", "last_name" => "BERTRAND" ],
    [ "first_name" => "Marie-Catherine", "last_name" => "BERTRAND" ],
    [ "first_name" => "Virginie Céleste", "last_name" => "BESSELIEVRE" ],
    [ "first_name" => "Marie", "last_name" => "BIHEL" ],
    [ "first_name" => "Rose-Françoise", "last_name" => "BLOUET" ],
    [ "first_name" => "Bonne Victoire", "last_name" => "BONNISSENT" ],
    [ "first_name" => "Jean Nicolas", "last_name" => "BONNISSENT" ],
    [ "first_name" => "Marie Scholastique", "last_name" => "BONNISSENT" ],
    [ "first_name" => "Bonne Françoise", "last_name" => "BUHOT" ],
    [ "first_name" => "Annick Simonne Madeleine", "last_name" => "CAILLOUX" ],
    [ "first_name" => "Bernard", "last_name" => "CALIPEL" ],
    [ "first_name" => "Adèle Marie Louise", "last_name" => "CALVY" ],
    [ "first_name" => "Anna Armandine", "last_name" => "CALVY" ],
    [ "first_name" => "Auguste", "last_name" => "CALVY" ],
    [ "first_name" => "Auguste Alfred", "last_name" => "CALVY" ],
    [ "first_name" => "Auguste Désiré", "last_name" => "CALVY" ],
    [ "first_name" => "Célestine Victorine", "last_name" => "CALVY" ],
    [ "first_name" => "Élisa Désirée", "last_name" => "CALVY" ],
    [ "first_name" => "Émile Ancelme", "last_name" => "CALVY" ],
    [ "first_name" => "François Joseph", "last_name" => "CALVY" ],
    [ "first_name" => "Jean Pierre Désiré", "last_name" => "CALVY" ],
    [ "first_name" => "Jean-Alphonse", "last_name" => "CALVY" ],
    [ "first_name" => "Jean-Baptiste Eugène", "last_name" => "CALVY" ],
    [ "first_name" => "Joseph Désiré", "last_name" => "CALVY" ],
    [ "first_name" => "Léon Alfred", "last_name" => "CALVY" ],
    [ "first_name" => "Louis Auguste", "last_name" => "CALVY" ],
    [ "first_name" => "Louis Étienne", "last_name" => "CALVY" ],
    [ "first_name" => "Marie Augustine", "last_name" => "CALVY" ],
    [ "first_name" => "Marie Pauline", "last_name" => "CALVY" ],
    [ "first_name" => "Pierre Alfred", "last_name" => "CALVY" ],
    [ "first_name" => "Pierre Désiré", "last_name" => "CALVY" ],
    [ "first_name" => "Pierre Marcellin (dit Pierre Désiré)", "last_name" => "CALVY" ],
    [ "first_name" => "Victoire Marie", "last_name" => "CALVY" ],
    [ "first_name" => "Victor Constant", "last_name" => "CALVY" ],
    [ "first_name" => "Marie", "last_name" => "CANNU" ],
    [ "first_name" => "Marie", "last_name" => "CANU" ],
    [ "first_name" => "Christine Isabelle Nathalie", "last_name" => "CASSIER" ],
    [ "first_name" => "Émile", "last_name" => "CASSIER" ],
    [ "first_name" => "Émile", "last_name" => "CASSIER" ],
    [ "first_name" => "Charles", "last_name" => "CAUVIN" ],
    [ "first_name" => "Marie Bonne Augustine", "last_name" => "CAUVIN" ],
    [ "first_name" => "Guy", "last_name" => "CHARPENTIER" ],
    [ "first_name" => "Jean Louis", "last_name" => "CHARPENTIER" ],
    [ "first_name" => "Louis", "last_name" => "CHARPENTIER" ],
    [ "first_name" => "Louis Robert Maurice", "last_name" => "CHARPENTIER" ],
    [ "first_name" => "Éric Patrick Raymond Edouard", "last_name" => "DUREL" ],
    [ "first_name" => "Florent Yves Bruno", "last_name" => "DUREL" ],
    [ "first_name" => "Raymond Alphonse Jean", "last_name" => "DUREL" ],
    [ "first_name" => "Etienne Bienaimé", "last_name" => "DUREL" ],
    [ "first_name" => "Jules Auguste", "last_name" => "DUREL" ],
    [ "first_name" => "Juliette Marie Augustine", "last_name" => "DUREL" ],
    [ "first_name" => "Cecile Rose-Marie Paulette", "last_name" => "DUREL" ],
    [ "first_name" => "Etienne Bienaimé", "last_name" => "DUREL" ],
    [ "first_name" => "Adéle Marie Alphonsine", "last_name" => "DUREL" ],
    [ "first_name" => "Augustine Marie", "last_name" => "DUREL" ],
    [ "first_name" => "Louis Léopold Jean", "last_name" => "DUREL" ],
    [ "first_name" => "Odette Angélique Louise", "last_name" => "DUREL" ],
    [ "first_name" => "Michel Jules Félix", "last_name" => "DUREL" ],
    [ "first_name" => "Luc Michel Paul", "last_name" => "DUREL" ],
    [ "first_name" => "Samuel Philippe Jean", "last_name" => "DUREL" ],
    [ "first_name" => "Auguste Désiré", "last_name" => "DUREL" ],
    [ "first_name" => "Paulette Alphonsine Andrée", "last_name" => "TRUFFERT" ],
    [ "first_name" => "Blanche Victorine Alphonsine", "last_name" => "TRAVERT" ],
    [ "first_name" => "Marie Alphonsine", "last_name" => "NAVET" ],
    [ "first_name" => "Cédulie Marie Eugénie", "last_name" => "PICOT" ],
    [ "first_name" => "Jules Edouard Henri", "last_name" => "PICOT" ],
    [ "first_name" => "Cédulie Marie Eugénie", "last_name" => "BENOIT" ],
    [ "first_name" => "Armandine (Alexandrine) Marie Augustine", "last_name" => "TRAVERT" ],
    [ "first_name" => "Félix Jean Baptiste", "last_name" => "TRUFFERT" ],
    [ "first_name" => "Suzanne Charlotte", "last_name" => "TRUFFERT" ],
    [ "first_name" => "André Jules Félix", "last_name" => "TRUFFERT" ],
    [ "first_name" => "Yves Pierre Gabriel", "last_name" => "TRUFFERT" ],
    [ "first_name" => "Andrée Marie Eugénie", "last_name" => "PORQUET" ],
    [ "first_name" => "Victor Bienaimé", "last_name" => "DUREL" ],
    [ "first_name" => "Marie Victoire", "last_name" => "DUREL" ],
    [ "first_name" => "Augustine Adèle", "last_name" => "DUREL" ],
    [ "first_name" => "Marie-Emélie", "last_name" => "DUREL" ],
    [ "first_name" => "Désirée Elisa", "last_name" => "DUREL" ],
    [ "first_name" => "Thérèse Michéle Josephine", "last_name" => "HÉLAINE" ],
    [ "first_name" => "Edouard Louis Emmanuel", "last_name" => "HÉLAINE" ],
    [ "first_name" => "Marie-Ange Adélaïde", "last_name" => "LECONTE" ],
    [ "first_name" => "Janine Alphonsine Jacqueline Fernande", "last_name" => "HÉLAINE" ],
    [ "first_name" => "Patrick Léonce Gilbert", "last_name" => "HÉLAINE" ],
    [ "first_name" => "Elisa Françoise Caroline", "last_name" => "DUVAL" ],
    [ "first_name" => "Angéline", "last_name" => "FRANÇOISE" ],
    [ "first_name" => "Emile Alfred Albert", "last_name" => "LECONTE" ],
    [ "first_name" => "Aspasie Marie Clotilde", "last_name" => "FOSSARD" ],
    [ "first_name" => "Emile Edouard Joseph Ferdinand", "last_name" => "HÉLAINE" ],
    [ "first_name" => "Ferdinand Auguste", "last_name" => "HÉLAINE" ],
    [ "first_name" => "Maria Euphrasie", "last_name" => "DEPATIN" ],
    [ "first_name" => "Désirée Maria Léonore", "last_name" => "DOYAND De La MOTTE" ],
    [ "first_name" => "Alphonsine", "last_name" => "PICOT" ],
    [ "first_name" => "Justine", "last_name" => "PICOT" ],
    [ "first_name" => "Justin Désiré", "last_name" => "PICOT" ],
    [ "first_name" => "Jules Clément François", "last_name" => "PICOT" ],
    [ "first_name" => "Alexandre Eugène", "last_name" => "TRUFFERT" ],
    [ "first_name" => "Augustine Fortunée", "last_name" => "GUESDON" ],
    [ "first_name" => "Victoire-Rosalie", "last_name" => "LESAGE" ],
    [ "first_name" => "Jean-Baptiste François", "last_name" => "TRUFFERT" ],
    [ "first_name" => "Marie-Catherine", "last_name" => "LUCAS" ],
    [ "first_name" => "Théophile", "last_name" => "GUESDON" ],
    [ "first_name" => "Henri Etienne François", "last_name" => "PICOT" ],
    [ "first_name" => "Marie Justine", "last_name" => "BENOIST" ],
    [ "first_name" => "Jeanne Françoise Antoinette", "last_name" => "LEPOITTEVIN" ],
    [ "first_name" => "Madeleine", "last_name" => "STRAGIER" ],
    [ "first_name" => "Jeanne Marie Rose", "last_name" => "LE MONNIER" ],
    [ "first_name" => "Charles Hyacinthe", "last_name" => "LETELLIER" ],
    [ "first_name" => "Françoise Marie", "last_name" => "RIMER" ],
    [ "first_name" => "Edouard Léon", "last_name" => "DUREL" ],
    [ "first_name" => "Léonie Adèle Henriette", "last_name" => "DUREL" ],
    [ "first_name" => "Jean Augustin", "last_name" => "DUREL" ],
    [ "first_name" => "Elizabeth Honorine", "last_name" => "SIGNE" ],
    [ "first_name" => "Christine Isabelle Nathalie", "last_name" => "Cassier" ],
    [ "first_name" => "Émile", "last_name" => "Cassier" ],
    [ "first_name" => "Margot Romane Justine", "last_name" => "Durel" ],
    [ "first_name" => "Thérèse Louisette Jeannine", "last_name" => "HÉBERT" ],
    [ "first_name" => "Juliette Pauline Manon", "last_name" => "DUREL" ],
    [ "first_name" => "Pierre Alexandre", "last_name" => "BENOIT" ],
    [ "first_name" => "Victor François", "last_name" => "NAVET" ],
    [ "first_name" => "Jean Félix Gabriel", "last_name" => "TRAVERT" ],
    [ "first_name" => "Bonne Marie Françoise", "last_name" => "TRAVERT" ],
    [ "first_name" => "Anne-Françoise", "last_name" => "VALLEE" ],
    [ "first_name" => "Louis Yves", "last_name" => "HERVÉ" ],
    [ "first_name" => "Auguste Jean François", "last_name" => "FRANÇOISE" ],
    [ "first_name" => "Marie", "last_name" => "NICOLET" ],
    [ "first_name" => "Jacqueline Yvonne Marie", "last_name" => "CAROF" ],
    [ "first_name" => "Jean Emmanuel", "last_name" => "HÉLAINE" ],
    [ "first_name" => "Marie-Josèphe Juliette", "last_name" => "HÉLAINE" ],
    [ "first_name" => "Étienne Frédéric René Jean-Marie", "last_name" => "HÉLAINE" ],
    [ "first_name" => "François Joseph Edouard", "last_name" => "HÉLAINE" ],
    [ "first_name" => "Victor Constant", "last_name" => "CALVY" ],
    [ "first_name" => "Marie-Françoise", "last_name" => "LE DANOIS" ],
    [ "first_name" => "Anna Armandine", "last_name" => "CALVY" ],
    [ "first_name" => "Charles Maximilien", "last_name" => "DEBONNET" ],
    [ "first_name" => "Joseph Désiré", "last_name" => "CALVY" ],
    [ "first_name" => "Henriette", "last_name" => "LEPARQUIER (PARQUIT)" ],
    [ "first_name" => "Auguste Alfred", "last_name" => "CALVY" ],
    [ "first_name" => "Jean-Baptiste Eugène", "last_name" => "CALVY" ],
    [ "first_name" => "Marie Augustine", "last_name" => "CALVY" ],
    [ "first_name" => "Victoire Marie", "last_name" => "CALVY" ],
    [ "first_name" => "Émile Ancelme", "last_name" => "CALVY" ],
    [ "first_name" => "Louis Auguste", "last_name" => "CALVY" ],
    [ "first_name" => "Auguste Désiré", "last_name" => "CALVY" ],
    [ "first_name" => "Élisa Désirée", "last_name" => "CALVY" ],
    [ "first_name" => "Louis Étienne", "last_name" => "CALVY" ],
    [ "first_name" => "Jean-Alphonse", "last_name" => "CALVY" ],
    [ "first_name" => "Célestine Victorine", "last_name" => "CALVY" ],
    [ "first_name" => "Auguste", "last_name" => "CALVY" ],
    [ "first_name" => "Marie Virginie Adélaïde", "last_name" => "JUMELIN" ],
    [ "first_name" => "François Joseph", "last_name" => "CALVY" ],
    [ "first_name" => "Pierre Désiré", "last_name" => "CALVY" ],
    [ "first_name" => "Virginie Céleste", "last_name" => "BESSELIEVRE" ],
    [ "first_name" => "Philippe Gabriel", "last_name" => "TRAVERT" ],
    [ "first_name" => "Anne Jeanne Catherine", "last_name" => "Le HARTEL" ],
    [ "first_name" => "Jean Michel", "last_name" => "TRAVERT" ],
    [ "first_name" => "Alphonse Gabriel", "last_name" => "TRAVERT" ],
    [ "first_name" => "Enfant-Sans-Vie", "last_name" => "TRAVERT" ],
    [ "first_name" => "Léon Alfred", "last_name" => "CALVY" ],
    [ "first_name" => "Pierre Alfred", "last_name" => "CALVY" ],
    [ "first_name" => "Marie Ernestine Charlotte", "last_name" => "MALHERBE" ],
    [ "first_name" => "Claude", "last_name" => "TRUFFERT" ],
    [ "first_name" => "Roland Felix Auguste", "last_name" => "TRUFFERT" ],
    [ "first_name" => "Pierre Aimable Gabriel", "last_name" => "DUREL" ],
    [ "first_name" => "Marie-Victoire", "last_name" => "LE GERRIES" ],
    [ "first_name" => "Alain Henri Louis", "last_name" => "HERVÉ" ],
    [ "first_name" => "Viviane Marceline Marguerite", "last_name" => "Leglise" ],
    [ "first_name" => "Isabelle Odette Nicole", "last_name" => "HERVÉ" ],
    [ "first_name" => "Stéphane Jacques William", "last_name" => "LANGELAAN" ],
    [ "first_name" => "Jean Baptiste Joseph", "last_name" => "PEPINO" ],
    [ "first_name" => "Simon Jean Baptiste", "last_name" => "PEPINO" ],
    [ "first_name" => "Rose", "last_name" => "GOSMELINO" ],
    [ "first_name" => "Victor François", "last_name" => "PEPINO" ],
    [ "first_name" => "Paul Lucien", "last_name" => "PÉPINO" ],
    [ "first_name" => "Joseph François", "last_name" => "PEPINO" ],
    [ "first_name" => "Louise Marguerite", "last_name" => "PEPINO" ],
    [ "first_name" => "Louise Jeanne Thérèse", "last_name" => "PEPINO" ],
    [ "first_name" => "Simon Joseph Lucien", "last_name" => "PEPINO" ],
    [ "first_name" => "Louis Jules", "last_name" => "PEPINO" ],
    [ "first_name" => "Joseph Marius Victor", "last_name" => "DUREL" ],
    [ "first_name" => "Marie Pauline", "last_name" => "CALVY" ],
    [ "first_name" => "Thomas Marie", "last_name" => "BENOIT" ],
    [ "first_name" => "Armand Joseph", "last_name" => "BENOIT" ],
    [ "first_name" => "Marie Alexandrine", "last_name" => "DESVERGEES" ],
    [ "first_name" => "François Xavier", "last_name" => "RIMER" ],
    [ "first_name" => "Rose Joséphine", "last_name" => "ARDISSON" ],
    [ "first_name" => "Constance Augustine Joséphine", "last_name" => "SANSON" ],
    [ "first_name" => "Frédéric François", "last_name" => "HÉLAINE" ],
    [ "first_name" => "Rosalie Adélaïde", "last_name" => "FOSSARD" ],
    [ "first_name" => "Victor Constant", "last_name" => "CALVY" ],
    [ "first_name" => "Blaise Joseph Marius", "last_name" => "SIGNE" ],
    [ "first_name" => "Marie", "last_name" => "PUGNAIRE" ],
    [ "first_name" => "Pierre-Dominique", "last_name" => "NAVET" ],
    [ "first_name" => "Marie-Françoise Catherine", "last_name" => "ADAM" ],
    [ "first_name" => "Jean-Baptiste", "last_name" => "LESAGE" ],
    [ "first_name" => "Bonne Caroline", "last_name" => "DUQUESNE" ],
    [ "first_name" => "Pierre François Michel", "last_name" => "TRAVERT Dit GALANDIN" ],
    [ "first_name" => "Marie Scholastique", "last_name" => "BONNISSENT" ],
    [ "first_name" => "Jean-Baptiste Gratien", "last_name" => "TRUFFERT" ],
    [ "first_name" => "Marie-Françoise", "last_name" => "QUEVASTRE" ],
    [ "first_name" => "Charles Céleste", "last_name" => "LUCAS" ],
    [ "first_name" => "Anne-Françoise", "last_name" => "VALOGNE" ],
    [ "first_name" => "Louis Marin", "last_name" => "GUESDON" ],
    [ "first_name" => "Bonne Aimée", "last_name" => "DUBOST" ],
    [ "first_name" => "Charles", "last_name" => "CAUVIN" ],
    [ "first_name" => "Marie", "last_name" => "CANU" ],
    [ "first_name" => "Jean", "last_name" => "PICOT" ],
    [ "first_name" => "Marie", "last_name" => "LE POITTEVIN" ],
    [ "first_name" => "Jacques Nicolas", "last_name" => "BENOIST" ],
    [ "first_name" => "Bonne Françoise", "last_name" => "BUHOT" ],
    [ "first_name" => "Alexandre", "last_name" => "BENOIT" ],
    [ "first_name" => "Marie", "last_name" => "GOHEL" ],
    [ "first_name" => "Charles François", "last_name" => "LEPOITTEVIN" ],
    [ "first_name" => "Jeanne Françoise", "last_name" => "Griffon" ],
    [ "first_name" => "Pierre Antoine", "last_name" => "SIGNE" ],
    [ "first_name" => "Marianne Baptistine", "last_name" => "PAUL" ],
    [ "first_name" => "Honoré Frédéric", "last_name" => "PUGNAIRE" ],
    [ "first_name" => "Catherine", "last_name" => "LECLERE" ],
    [ "first_name" => "Pierre Elie", "last_name" => "JANOT" ],
    [ "first_name" => "Baptiste", "last_name" => "JANOT" ],
    [ "first_name" => "Nathalie", "last_name" => "Zvenigorosky" ],
    [ "first_name" => "Julien", "last_name" => "DUREL" ],
    [ "first_name" => "Vincent", "last_name" => "DUREL" ],
    [ "first_name" => "Matthieu", "last_name" => "DUREL" ],
    [ "first_name" => "Cécile", "last_name" => "DUREL" ],
    [ "first_name" => "Thomas", "last_name" => "DUREL" ],
    [ "first_name" => "Meike", "last_name" => "Schonrock" ],
    [ "first_name" => "Jacques Pierre", "last_name" => "DUREL" ],
    [ "first_name" => "Marie Jacqueline", "last_name" => "RENAULT" ],
    [ "first_name" => "Jacques Martin", "last_name" => "DUREL" ],
    [ "first_name" => "Anne Marie Charlotte", "last_name" => "DUREL" ],
    [ "first_name" => "Nicolas", "last_name" => "VALLÉE" ],
    [ "first_name" => "Marie", "last_name" => "LORINE" ],
    [ "first_name" => "Pierre", "last_name" => "DUREL" ],
    [ "first_name" => "Anne", "last_name" => "TRAVERS" ],
    [ "first_name" => "Adrien", "last_name" => "TRAVERS" ],
    [ "first_name" => "Jeanne", "last_name" => "Le BREDONCHEL" ],
    [ "first_name" => "Charles", "last_name" => "LE GERRIES" ],
    [ "first_name" => "Anne Françoise Marguerite", "last_name" => "FOUILLARD" ],
    [ "first_name" => "Michel", "last_name" => "TRAVERT DIT GALANDIN" ],
    [ "first_name" => "Charlotte", "last_name" => "LAINÉ" ],
    [ "first_name" => "Jean Nicolas", "last_name" => "BONNISSENT" ],
    [ "first_name" => "Bonne Victoire", "last_name" => "BONNISSENT" ],
    [ "first_name" => "Adélaïde", "last_name" => "TRAVERT" ],
    [ "first_name" => "Pierre", "last_name" => "NAVET" ],
    [ "first_name" => "Marie-Françoise", "last_name" => "VALQUIER" ],
    [ "first_name" => "Christophe Etienne", "last_name" => "ADAM" ],
    [ "first_name" => "Marie Françoise", "last_name" => "LEVAUFRE" ],
    [ "first_name" => "Rosalie Justine", "last_name" => "NAVET" ],
    [ "first_name" => "Jean Pierre", "last_name" => "NAVET" ],
    [ "first_name" => "Louise Charlotte", "last_name" => "NAVET" ],
    [ "first_name" => "Victor François", "last_name" => "NAVET" ],
    [ "first_name" => "Augustine Andréa", "last_name" => "DUREL" ],
    [ "first_name" => "Gilles", "last_name" => "DUREL" ],
    [ "first_name" => "Marie", "last_name" => "CANNU" ],
    [ "first_name" => "Gilles", "last_name" => "DUREL" ],
    [ "first_name" => "Jacqueline", "last_name" => "TRAVERS" ],
    [ "first_name" => "Auguste", "last_name" => "DUVAL" ],
    [ "first_name" => "Marie", "last_name" => "GAILLARD" ],
    [ "first_name" => "Augustin", "last_name" => "BELLIOT" ],
    [ "first_name" => "René Auguste Ludovic", "last_name" => "HÉBERT" ],
    [ "first_name" => "Louise Eugénie Ernestine", "last_name" => "Tillault" ],
    [ "first_name" => "Ludovic Albert Jules", "last_name" => "HÉBERT" ],
    [ "first_name" => "Angéline Marie", "last_name" => "GROUSSARD" ],
    [ "first_name" => "Janica", "last_name" => "Vrban" ],
    [ "first_name" => "Aimée Victoire", "last_name" => "Nativelle" ],
    [ "first_name" => "Jean Charles", "last_name" => "GROUSSARD" ],
    [ "first_name" => "Joseph-François", "last_name" => "HÉBERT" ],
    [ "first_name" => "Rose-Françoise", "last_name" => "Allix" ],
    [ "first_name" => "Félix Honoré", "last_name" => "Groussard" ],
    [ "first_name" => "Jacques-François", "last_name" => "HÉBERT" ],
    [ "first_name" => "Aimée Rosalie", "last_name" => "Pellerin" ],
    [ "first_name" => "Pierre-François", "last_name" => "ALLIX" ],
    [ "first_name" => "Rose-Françoise", "last_name" => "Blouet" ],
    [ "first_name" => "François", "last_name" => "HÉBERT" ],
    [ "first_name" => "Anne Marie", "last_name" => "Quesnet" ],
    [ "first_name" => "Rose", "last_name" => "Pellerin" ],
    [ "first_name" => "Pierre", "last_name" => "QUESNET" ],
    [ "first_name" => "Anne", "last_name" => "Moret" ],
    [ "first_name" => "Jean-François", "last_name" => "HÉBERT" ],
    [ "first_name" => "X", "last_name" => "Inconnu" ],
    [ "first_name" => "Antoine", "last_name" => "PELLERIN" ],
    [ "first_name" => "Marguerite", "last_name" => "Houssin" ],
    [ "first_name" => "Marie", "last_name" => "Georges" ],
    [ "first_name" => "X", "last_name" => "Père Inconnu" ],
    [ "first_name" => "Émile", "last_name" => "Cassier" ],
    [ "first_name" => "Bara", "last_name" => "Vrban" ],
    [ "first_name" => "Blaise", "last_name" => "Salapic" ],
    [ "first_name" => "Clémentine Solange", "last_name" => "ROUX" ],
    [ "first_name" => "Yvonne", "last_name" => "Hébert" ],
    [ "first_name" => "Raymond", "last_name" => "TILLAULT" ],
    [ "first_name" => "Félicia Marie", "last_name" => "Lemieux" ],
    [ "first_name" => "Jean-Claude", "last_name" => "HÉBERT" ],
    [ "first_name" => "Renée", "last_name" => "HÉBERT" ],
    [ "first_name" => "Marcelle", "last_name" => "HÉBERT" ],
    [ "first_name" => "Andrée", "last_name" => "HÉBERT" ],
    [ "first_name" => "Léonard", "last_name" => "CASSIER" ],
    [ "first_name" => "Louise Augustine", "last_name" => "PREJEAN" ],
    [ "first_name" => "Alexandre Jean-Baptiste", "last_name" => "TRUFFERT" ],
    [ "first_name" => "Marie Augustine", "last_name" => "LECARPENTIER" ],
    [ "first_name" => "Louis Jean Baptiste", "last_name" => "LECARPENTIER" ],
    [ "first_name" => "Marie Célestine Anastasie", "last_name" => "LE TOURNEUR" ],
    [ "first_name" => "Albert Victor Eugène", "last_name" => "Travert" ],
    [ "first_name" => "Virginie Clémence", "last_name" => "Vaultier" ],
    [ "first_name" => "Louis Jean Michel", "last_name" => "Travert" ],
    [ "first_name" => "Léonord", "last_name" => "VAULTIER" ],
    [ "first_name" => "Joséphine Marie Augustine", "last_name" => "LECONTE" ]
    // Ajoutez ici toutes les autres personnes que vous souhaitez rechercher
];

// Traitement des personnes pour vérifier les doublons et mettre les last_name en majuscules
$result = processPeople( $people );
$processedPeople = $result[ 'processedPeople' ];
$duplicates = $result[ 'duplicates' ];

if ( !empty( $duplicates ) ) {
    echo "Il y a des doublons dans la liste :<br>";
    foreach ( $duplicates as $duplicate ) {
        echo $duplicate . "<br>";
    }
} else {
    echo "Il n'y a pas de doublons dans la liste.<br>";
}

try {
    // Connexion à la base de données
    include 'connexion.php';


    $conn = new PDO( "mysql:host=$servername;dbname=$dbname", $username, $password );
    // Définir le mode d'erreur PDO sur exception
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    // Préparation de la requête SQL avec des paramètres
    $sql = "SELECT * FROM gedcom_data WHERE ";
    $conditions = [];
    foreach ( $processedPeople as $key => $person ) {
        // Ajouter chaque condition pour chaque personne
        $conditions[] = "(first_name = :first_name_$key AND last_name = :last_name_$key)";
    }
    $sql .= implode( " OR ", $conditions );

    // Préparer la requête
    $stmt = $conn->prepare( $sql );

    // Lier les paramètres
    foreach ( $processedPeople as $key => $person ) {
        $stmt->bindParam( ":first_name_$key", $person[ 'first_name' ] );
        $stmt->bindParam( ":last_name_$key", $person[ 'last_name' ] );
    }

    // Exécuter la requête
    $stmt->execute();

    // Récupérer les résultats sous forme d'associatif
    $results = $stmt->fetchAll( PDO::FETCH_ASSOC );

    // Créer un tableau pour stocker les personnes trouvées
    $people_found = [];
    foreach ( $results as $result ) {
        $people_found[] = $result[ 'first_name' ] . " " . $result[ 'last_name' ];
    }

    // Comparer avec la liste originale pour trouver les personnes absentes
    $people_not_found = array_diff( array_map( function ( $person ) {
        return $person[ 'first_name' ] . " " . $person[ 'last_name' ];
    }, $processedPeople ), $people_found );

    // Afficher les personnes absentes
    if ( !empty( $people_not_found ) ) {
        echo '<br>';
        echo "Les personnes suivantes ne sont pas dans la base gedcom_data :<br><br>";
        foreach ( $people_not_found as $person_not_found ) {
            echo $person_not_found . "<br>";
        }
    } else {
        echo "Toutes les personnes de la liste sont dans la base de données.";
    }

} catch ( PDOException $e ) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
} finally {
    // Fermer la connexion
    $conn = null;
}
?>
