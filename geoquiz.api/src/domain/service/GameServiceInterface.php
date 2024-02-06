<?php

namespace geoquiz\api\domain\service;

interface GameServiceInterface
{

    // Get all the difficulties available
    public function getDifficulties(): array;

}