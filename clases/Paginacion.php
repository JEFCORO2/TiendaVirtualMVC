<?php 

namespace Clases;

class Paginacion {
    public $pagina_actual;
    public $registros_por_pagina;
    public $total_registros;

    public function __construct($pagina_actual = 1, $registros_por_pagina = 10, $total_registros = 0 )
    {
        $this->pagina_actual = (int) $pagina_actual;
        $this->registros_por_pagina = (int) $registros_por_pagina;
        $this->total_registros = (int) $total_registros;
    }

    public function offset() {
        return $this->registros_por_pagina * ($this->pagina_actual - 1);
    }

    public function total_paginas() {
        $total = ceil($this->total_registros / $this->registros_por_pagina);
        $total == 0 ? $total = 1 : $total = $total;
        return $total;
    }

    public function pagina_anterior() {
        $anterior = $this->pagina_actual - 1;
        return ($anterior > 0) ? $anterior : false;
    }

    public function pagina_siguiente() {
        $siguiente = $this->pagina_actual + 1;
        return ($siguiente <= $this->total_paginas()) ? $siguiente : false;
    }

    public function enlace_anterior() {
        $html = '';
        if ($this->pagina_anterior()) {
            $html .= "<li class='page-item'><a class='page-link rounded-0 mr-3 shadow-sm border-top-0 border-left-0 text-dark' href='?page={$this->pagina_anterior()}'>&laquo; Anterior</a></li>";
        } else {
            $html .= "<li class='page-item disabled'><a class='page-link rounded-0 mr-3 shadow-sm border-top-0 border-left-0' tabindex='-1'>&laquo; Anterior</a></li>";
        }
        return $html;
    }
    
    public function enlace_siguiente() {
        $html = '';
        if ($this->pagina_siguiente()) {
            $html .= "<li class='page-item'><a class='page-link rounded-0 mr-3 shadow-sm border-top-0 border-left-0 text-dark' href='?page={$this->pagina_siguiente()}'>Siguiente &raquo;</a></li>";
        } else {
            $html .= "<li class='page-item disabled'><a class='page-link rounded-0 mr-3 shadow-sm border-top-0 border-left-0' tabindex='-1'>Siguiente &raquo;</a></li>";
        }
        return $html;
    }
    
    public function numeros_paginas() {
        $html = '';
        for ($i = 1; $i <= $this->total_paginas(); $i++) {
            if ($i === $this->pagina_actual) {
                $html .= "<li class='page-item active'><a class='page-link rounded-0 mr-3 shadow-sm border-top-0 border-left-0' href='?page={$i}'>{$i}</a></li>";
            } else {
                $html .= "<li class='page-item'><a class='page-link rounded-0 mr-3 shadow-sm border-top-0 border-left-0 text-dark' href='?page={$i}'>{$i}</a></li>";
            }
        }
        return $html;
    }
    
    public function paginacion() {
        $html = '';
        if ($this->total_registros > 1) {
            $html .= '<div class="row"><ul class="pagination pagination-lg justify-content-end">';
            $html .= $this->enlace_anterior();
            $html .= $this->numeros_paginas();
            $html .= $this->enlace_siguiente();
            $html .= '</ul></div>';
        }
        return $html;
    }
}