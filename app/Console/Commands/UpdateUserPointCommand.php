<?php
namespace App\Console\Commands;

use App\Services\PointServiceInterface;
use Illuminate\Console\Command;

class UpdateUserPointCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'point:expired-schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user point by expired point';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    /** @var PointServiceInterface $pointService */
    protected $pointService;

    public function __construct(
        PointServiceInterface $pointService
    ) {
        parent::__construct();
        $this->pointService = $pointService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->pointService->expirePoints();
    }
}
