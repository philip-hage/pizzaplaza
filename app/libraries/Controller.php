<?php
// De parent controllerclass laad de model en de view

class Controller
{
    public function model($model)
    {
        // Pad naar de modelclass bestand opgeven
        require_once APPROOT . '/models/' . $model . '.php';

        // Nieuw object van de opgegeven model
        return new $model();
    }


    public function view($view, $data = [])
    {
        if (file_exists(APPROOT . '/views/includes/Header.php')) {
            require_once APPROOT . '/views/includes/Header.php';
        }
        if (file_exists(APPROOT . '/views/' . $view . '.php')) {
            require_once(APPROOT . '/views/' . $view . '.php');
        } else {
            die('View bestaat niet');
        }
        if (file_exists(APPROOT . '/views/includes/footer.php')) {
            require_once APPROOT . '/views/includes/footer.php';
        }
    }

    public function pagination($pageNumber, $recordsPerPage, $totalRecords)
    {
        $totalPages = ceil($totalRecords / $recordsPerPage);
        $offset = ($pageNumber * $recordsPerPage) - $recordsPerPage;
        $nextPage = $pageNumber +1;
        $previousPage = $pageNumber - 1;
        $firstPage = 1;
        $secondPage = 2;
        $thirdPage = 3;

        // Page number 1
        if ($pageNumber == 1) {
            $firstPage = $pageNumber;
        } else {
            if ($pageNumber == $totalPages) {
                $firstPage = $pageNumber - 2;
            } else {
                $firstPage = $pageNumber - 1;
            }
        }

        if ($pageNumber == 2){
            if ($pageNumber == $totalPages)
            {
            $firstPage = $pageNumber - 1 ;  
            } else {
                $firstPage = $pageNumber - 1;
            }
        }

        //Page number 2
        if($pageNumber != 1)
        {
            $secondPage = $pageNumber;
            if($pageNumber == $totalPages) {
               $secondPage = $pageNumber -1;
            }else {
                $secondPage = $pageNumber;
            }
        }else {
            $secondPage = $pageNumber + 1;
        }

        if ($pageNumber == 2)
        {
            if ($pageNumber == $totalPages)
            {
            $secondPage = $pageNumber;
            } else {
                 $secondPage = $pageNumber;
            }
        }

        //Page number 3
        if ($pageNumber == 1 || $pageNumber == 2) {
            $thirdPage = 3;
        } elseif ($pageNumber == $totalPages) {
            $thirdPage = $pageNumber;
        } else {
            $thirdPage = $pageNumber + 1;
        }
        
        return $data = [
            'pageNumber' => $pageNumber,
            'recordsPerPage' => $recordsPerPage,
            'offset' => $offset,
            'nextPage' => $nextPage,
            'previousPage' => $previousPage,
            'totalPages' => $totalPages,
            'firstPage' => $firstPage,
            'secondPage' => $secondPage,
            'thirdPage' => $thirdPage
        ];
    }

}