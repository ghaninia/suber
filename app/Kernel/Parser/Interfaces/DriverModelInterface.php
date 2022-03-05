<?php

namespace App\Kernel\Parser\Interfaces ;

use Illuminate\Database\Eloquent\Relations\HasMany;

interface DriverModelInterface {

    public function update(array $data) ;

    public function links() : HasMany ;

}
