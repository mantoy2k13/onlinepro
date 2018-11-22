<?php
/**
 * Created by PhpStorm.
 * User: ironh
 * Date: 4/5/2017
 * Time: 11:26 PM.
 */
namespace App\Console\Commands;

use App\Services\BookingServiceInterface;
use Illuminate\Console\Command;

class UpdateBoookingFinishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:finish-booking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status for booking finish';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    /** @var BookingServiceInterface $bookingService */
    protected $bookingService;

    public function __construct(
        BookingServiceInterface $bookingService
    ) {
        parent::__construct();
        $this->bookingService = $bookingService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->bookingService->updateBookingFinish();
    }
}
