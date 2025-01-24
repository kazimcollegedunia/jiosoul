<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AmountCollection;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsersDetails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jio:user_details';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

       // $amounts = [
       //          ['id'=>2, 'payment' => ['sept' => 1200 ,'oct' => 1240, 'nov' => 1200, 'dec' => 1240 , 'jan' => 1240]],
       //      ['id'=>3, 'payment' => ['sept' => 600 ,'oct' => 620, 'nov' => 600, 'dec' => 620 , 'jan' => 620]],
       //      ['id'=>4, 'payment' => ['sept' => 600 ,'oct' => 620, 'nov' => 600, 'dec' => 0 , 'jan' => 0]],
       //      ['id'=>5, 'payment' => ['sept' => 600 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 0]],
       //      ['id'=>6, 'payment' => ['sept' => 1200 ,'oct' => 1240, 'nov' => 1200, 'dec' => 1240 , 'jan' => 1240]],
       //      ['id'=>7, 'payment' => ['sept' => 1200 ,'oct' => 1240, 'nov' => 1200, 'dec' => 1240 , 'jan' => 1240]],
       //      ['id'=>8, 'payment' => ['sept' => 600 ,'oct' => 620, 'nov' => 600, 'dec' => 620 , 'jan' => 620]],
       //      ['id'=>9, 'payment' => ['sept' => 1800 ,'oct' => 1860, 'nov' => 1800, 'dec' => 0 , 'jan' => 0]],
       //      ['id'=>10, 'payment' => ['sept' => 3000 ,'oct' => 3100, 'nov' => 3000, 'dec' => 3100 , 'jan' => 3100]],
       //      ['id'=>11, 'payment' => ['sept' => 3000 ,'oct' => 3100, 'nov' => 3000, 'dec' => 3100 , 'jan' => 3100]],
       //      ['id'=>12, 'payment' => ['sept' => 1200 ,'oct' => 1240, 'nov' => 1200, 'dec' => 1240 , 'jan' => 840]],
       //      ['id'=>13, 'payment' => ['sept' => 3000 ,'oct' => 4340, 'nov' => 4340, 'dec' => 5490 , 'jan' => 7440]],
       //      ['id'=>14, 'payment' => ['sept' => 600 ,'oct' => 620, 'nov' => 600, 'dec' => 620 , 'jan' => 620]],
       //      ['id'=>15, 'payment' => ['sept' => 600 ,'oct' => 620, 'nov' => 600, 'dec' => 620 , 'jan' => 620]],
       //      ['id'=>16, 'payment' => ['sept' => 600 ,'oct' => 620, 'nov' => 600, 'dec' => 620 , 'jan' => 620]],
       //      ['id'=>17, 'payment' => ['sept' => 3000 ,'oct' => 3100, 'nov' => 3000, 'dec' => 3100 , 'jan' => 3100]],
       //      ['id'=>18, 'payment' => ['sept' => 3000 ,'oct' => 3100, 'nov' => 3000, 'dec' => 3100 , 'jan' => 3100]],
       //      ['id'=>19, 'payment' => ['sept' => 600 ,'oct' => 620, 'nov' => 600, 'dec' => 620 , 'jan' => 620]],
       //      ['id'=>20, 'payment' => ['sept' => 600 ,'oct' => 620, 'nov' => 700, 'dec' => 0 , 'jan' => 0]],
       //      ['id'=>21, 'payment' => ['sept' => 3000 ,'oct' => 3100, 'nov' => 3000, 'dec' => 3100 , 'jan' => 3100]],
       //      ['id'=>22, 'payment' => ['sept' => 600 ,'oct' => 620, 'nov' => 600, 'dec' => 620 , 'jan' => 620]],
       //      ['id'=>23, 'payment' => ['sept' => 1800 ,'oct' => 1860, 'nov' => 1800, 'dec' => 1860 , 'jan' => 1860]],
       //      ['id'=>24, 'payment' => ['sept' => 600 ,'oct' => 580, 'nov' => 0, 'dec' => 0 , 'jan' => 0]],
       //      ['id'=>25, 'payment' => ['sept' => 600 ,'oct' => 620, 'nov' => 620, 'dec' => 0 , 'jan' => 0]],
       //      ['id'=>26, 'payment' => ['sept' => 1200 ,'oct' => 1300, 'nov' => 0, 'dec' => 0 , 'jan' => 0]],
       //      ['id'=>27, 'payment' => ['sept' => 1200 ,'oct' => 1200, 'nov' => 1200, 'dec' => 1000 , 'jan' => 0]],
       //      ['id'=>28, 'payment' => ['sept' => 1200 ,'oct' => 1240, 'nov' => 1200, 'dec' => 1240 , 'jan' => 800]],
       //      ['id'=>29, 'payment' => ['sept' => 600 ,'oct' => 620, 'nov' => 600, 'dec' => 620 , 'jan' => 620]],
       //      ['id'=>30, 'payment' => ['sept' => 1200 ,'oct' => 1240, 'nov' => 1200, 'dec' => 1240 , 'jan' => 0]],
       //      ['id'=>31, 'payment' => ['sept' => 600 ,'oct' => 620, 'nov' => 600, 'dec' => 620 , 'jan' => 620]],
       //      ['id'=>32, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 0]],
       //      ['id'=>33, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 0]],
       //      ['id'=>34, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 0]],
       //      ['id'=>35, 'payment' => ['sept' => 600 ,'oct' => 620, 'nov' => 600, 'dec' => 620 , 'jan' => 620]],
       //      ['id'=>36, 'payment' => ['sept' => 1800 ,'oct' => 1860, 'nov' => 1800, 'dec' => 1860 , 'jan' => 900]],
       //      ['id'=>37, 'payment' => ['sept' => 1800 ,'oct' => 1860, 'nov' => 1800, 'dec' => 1860 , 'jan' => 0]],
       //      ['id'=>38, 'payment' => ['sept' => 600 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 0]],
       //      ['id'=>39, 'payment' => ['sept' => 1200 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 0]],
       //      ['id'=>40, 'payment' => ['sept' => 600 ,'oct' => 620, 'nov' => 600, 'dec' => 620 , 'jan' => 0]],
       //      ['id'=>41, 'payment' => ['sept' => 3000 ,'oct' => 3100, 'nov' => 3000, 'dec' => 1000 , 'jan' => 0]],
       //      ['id'=>42, 'payment' => ['sept' => 1200 ,'oct' => 1240, 'nov' => 1200, 'dec' => 1240 , 'jan' => 650]],
       //      ['id'=>43, 'payment' => ['sept' => 600 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 0]],
       //      ['id'=>44, 'payment' => ['sept' => 1200 ,'oct' => 1240, 'nov' => 1200, 'dec' => 1240 , 'jan' => 0]],
       //      ['id'=>45, 'payment' => ['sept' => 600 ,'oct' => 620, 'nov' => 600, 'dec' => 620 , 'jan' => 620]],
       //      ['id'=>46, 'payment' => ['sept' => 600 ,'oct' => 620, 'nov' => 600, 'dec' => 620 , 'jan' => 620]],
       //      ['id'=>47, 'payment' => ['sept' => 600 ,'oct' => 620, 'nov' => 600, 'dec' => 200 , 'jan' => 0]],
       //      ['id'=>48, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 0]],
       //      ['id'=>49, 'payment' => ['sept' => 600 ,'oct' => 620, 'nov' => 600, 'dec' => 620 , 'jan' => 620]],
       //      ['id'=>50, 'payment' => ['sept' => 600 ,'oct' => 620, 'nov' => 600, 'dec' => 620 , 'jan' => 520]],
       //      ['id'=>51, 'payment' => ['sept' => 600 ,'oct' => 620, 'nov' => 600, 'dec' => 620 , 'jan' => 620]],
       //      ['id'=>52, 'payment' => ['sept' => 600 ,'oct' => 620, 'nov' => 600, 'dec' => 620 , 'jan' => 400]],
       //      ['id'=>53, 'payment' => ['sept' => 20 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 0]],
       //      ['id'=>54, 'payment' => ['sept' => 0 ,'oct' => 620, 'nov' => 600, 'dec' => 620 , 'jan' => 440]],
       //      ['id'=>55, 'payment' => ['sept' => 80 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 0]],
       //      ['id'=>56, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 0]],
       //      ['id'=>57, 'payment' => ['sept' => 600 ,'oct' => 620, 'nov' => 600, 'dec' => 620 , 'jan' => 620]],
       //      ['id'=>58, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 0]],
       //      ['id'=>59, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 0]],
       //      ['id'=>60, 'payment' => ['sept' => 0 ,'oct' => 620, 'nov' => 600, 'dec' => 620 , 'jan' => 620]],
       //      ['id'=>61, 'payment' => ['sept' => 0 ,'oct' => 620, 'nov' => 600, 'dec' => 620 , 'jan' => 620]],
       //      ['id'=>62, 'payment' => ['sept' => 600 ,'oct' => 620, 'nov' => 600, 'dec' => 620 , 'jan' => 620]],
       //      ['id'=>63, 'payment' => ['sept' => 600 ,'oct' => 1240, 'nov' => 1200, 'dec' => 1240 , 'jan' => 1240]],
       //      ['id'=>64, 'payment' => ['sept' => 0 ,'oct' => 620, 'nov' => 600, 'dec' => 620 , 'jan' => 620]],
       //      ['id'=>65, 'payment' => ['sept' => 0 ,'oct' => 620, 'nov' => 600, 'dec' => 620 , 'jan' => 620]],
       //      ['id'=>66, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 1860]],
       //      ['id'=>67, 'payment' => ['sept' => 0 ,'oct' => 1240, 'nov' => 1200, 'dec' => 1240 , 'jan' => 1240]],
       //      ['id'=>68, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 620, 'dec' => 600 , 'jan' => 620]],
       //      ['id'=>69, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 600, 'dec' => 620 , 'jan' => 620]],
       //      ['id'=>70, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 1200, 'dec' => 1240 , 'jan' => 1240]],
       //      ['id'=>71, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 0]],
       //      ['id'=>72, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 1800, 'dec' => 1860 , 'jan' => 1860]],
       //      ['id'=>73, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 0]],
       //      ['id'=>74, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 600, 'dec' => 620 , 'jan' => 620]],
       //      ['id'=>75, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 1860 , 'jan' => 1860]],
       //      ['id'=>76, 'payment' => ['sept' => 1200 ,'oct' => 2000, 'nov' => 0, 'dec' => 0 , 'jan' => 0]],
       //      ['id'=>77, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 1240]],
       //      ['id'=>78, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 3100 , 'jan' => 3100]],
       //      ['id'=>79, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 400]],
       //      ['id'=>80, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 620 , 'jan' => 620]],
       //      ['id'=>81, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 990 , 'jan' => 0]],
       //      ['id'=>82, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 1060 , 'jan' => 0]],
       //      ['id'=>83, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 0]],
       //      ['id'=>84, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 0]],
       //      ['id'=>85, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 0]],
       //      ['id'=>86, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 500 , 'jan' => 0]],
       //      ['id'=>87, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 40]],
       //      ['id'=>88, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 0]],
       //      ['id'=>89, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 1240]],
       //      ['id'=>90, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 0]],
       //      ['id'=>91, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 600]],
       //      ['id'=>92, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 1200]],
       //      ['id'=>93, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 1200]],
       //      ['id'=>94, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 300]],
       //      ['id'=>95, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 160]],
       //      ['id'=>96, 'payment' => ['sept' => 600 ,'oct' => 620, 'nov' => 600, 'dec' => 620 , 'jan' => 620]],
       //      ['id'=>97, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 20]],
       //      ['id'=>98, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 20]],
       //      ['id'=>99, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 20]],
       //      ['id'=>100, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 280]],
       //      ['id'=>101, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 620]],
       //      ['id'=>102, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 620]],
       //      ['id'=>103, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 600]],
       //      ['id'=>104, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 600]],
       //      ['id'=>105, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 140]],
       //      ['id'=>106, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 100]],
       //      ['id'=>107, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 3100]],
       //      ['id'=>108, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 3100]],
       //      ['id'=>109, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 200]],
       //      ['id'=>110, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 800]],
       //      ['id'=>111, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 1040]],
       //      ['id'=>112, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 1240]],
       //      ['id'=>113, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 240]],
       //      ['id'=>114, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 1200]],
       //      ['id'=>115, 'payment' => ['sept' => 2400 ,'oct' => 2480, 'nov' => 2400, 'dec' => 2480 , 'jan' => 0]],
       //      ['id'=>116, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 0 , 'jan' => 1240]],
       //      ['id'=>117, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 320, 'dec' => 0 , 'jan' => 0]],
       //      ['id'=>118, 'payment' => ['sept' => 0 ,'oct' => 0, 'nov' => 0, 'dec' => 800 , 'jan' => 0]],
       //  ];

       //      $dates = [
       //          'sept' => '2023-09-30',
       //          'oct' => '2023-10-31',
       //          'nov' => '2023-11-30',
       //          'dec' => '2023-12-31',
       //          'jan' => '2024-01-31',
       //          // Add more months as needed
       //      ];

       //  foreach ($amounts as $amount) {
       //      foreach ($amount['payment'] as $month => $payment) {
       //          if($payment){
       //              $a = new AmountCollection;
       //              $a->user_id = $amount['id'];
       //              $a->payment_mode = 'cash';
       //              $a->date = $dates[$month];
       //              $a->amount = $payment;
       //              $a->status = true;
       //              $a->submit_by = true;
       //              $a->save();
       //          }
       //      }      
       //  }

        $users = [['id'=>1 , 'employee_id' =>   'JIO101', 'name' => 'suresh sani'],
                ['id'=>2 , 'employee_id' => 'JIO102', 'name' => 'Bhumika and Shivangi Sai'],
                ['id'=>3 , 'employee_id' => 'JIO103', 'name' => 'Ashok Tawar'],
                ['id'=>4 , 'employee_id' => 'JIO104', 'name' => 'Sharwan Ji Khora'],
                ['id'=>5 , 'employee_id' => 'JIO105', 'name' => 'Sankar Ji Khora'],
                ['id'=>6 , 'employee_id' => 'JIO106', 'name' => 'Ashok D5'],
                ['id'=>7 , 'employee_id' => 'JIO107', 'name' => 'Kishan Singhadiya'],
                ['id'=>8 , 'employee_id' => 'JIO108', 'name' => 'RamKaran Saini'],
                ['id'=>9 , 'employee_id' => 'JIO109', 'name' => 'Ramkishore Saini (Mothu Ka Bas)'],
                ['id'=>10 , 'employee_id' =>    'JIO110', 'name' => 'Laxman Saini'],
                ['id'=>11 , 'employee_id' =>    'JIO111', 'name' => 'Kana Ram Katariya'],
                ['id'=>12 , 'employee_id' =>    'JIO112', 'name' => 'Nathu Singhadiya'],
                ['id'=>13 , 'employee_id' =>    'JIO113', 'name' => 'Mool Ji Saini'],
                ['id'=>14 , 'employee_id' =>    'JIO114', 'name' => 'Vikas Meena'],
                ['id'=>15 , 'employee_id' =>    'JIO115', 'name' => 'Santosh Saini'],
                ['id'=>16 , 'employee_id' =>    'JIO116', 'name' => 'Vikash Saini'],
                ['id'=>17 , 'employee_id' =>    'JIO117', 'name' => 'Parkash Mandi'],
                ['id'=>18 , 'employee_id' =>    'JIO118', 'name' => 'Praveen Saini'],
                ['id'=>19 , 'employee_id' =>    'JIO119', 'name' => 'Shimbu saini'],
                ['id'=>20 , 'employee_id' =>    'JIO120', 'name' => 'Maharaj Gutka'],
                ['id'=>21 , 'employee_id' =>    'JIO121', 'name' => 'Suresh (prem nagar)'],
                ['id'=>22 , 'employee_id' =>    'JIO122', 'name' => 'Sanjay D5'],
                ['id'=>23 , 'employee_id' =>    'JIO123', 'name' => 'Ravi Mandi'],
                ['id'=>24 , 'employee_id' =>    'JIO124', 'name' => 'Suresh Topi'],
                ['id'=>25 , 'employee_id' =>    'JIO125', 'name' => 'Bablu Nindar'],
                ['id'=>26 , 'employee_id' =>    'JIO126', 'name' => 'Rohit Singhadiya'],
                ['id'=>27 , 'employee_id' =>    'JIO127', 'name' => 'Ramjilal Yogi'],
                ['id'=>28 , 'employee_id' =>    'JIO128', 'name' => 'Amitabh Singhadiya'],
                ['id'=>29 , 'employee_id' =>    'JIO129', 'name' => 'Rajesh Meena'],
                ['id'=>30 , 'employee_id' =>    'JIO130', 'name' => 'Sagar Pawar'],
                ['id'=>31 , 'employee_id' =>    'JIO131', 'name' => 'Narsi Mandi'],
                ['id'=>32 , 'employee_id' =>    'JIO132', 'name' => 'Pinku Mandi'],
                ['id'=>33 , 'employee_id' =>    'JIO133', 'name' => 'Banwari Jaat'],
                ['id'=>34 , 'employee_id' =>    'JIO134', 'name' => 'Sawarmal Yadav'],
                ['id'=>35 , 'employee_id' =>    'JIO135', 'name' => 'Suresh Garna'],
                ['id'=>36 , 'employee_id' =>    'JIO136', 'name' => 'Ramshay Saini'],
                ['id'=>37 , 'employee_id' =>    'JIO137', 'name' => 'Suresh Sharma'],
                ['id'=>38 , 'employee_id' =>    'JIO138', 'name' => 'Norti devi WO Sankar Set'],
                ['id'=>39 , 'employee_id' =>    'JIO139', 'name' => 'Devrazz sharma'],
                ['id'=>40 , 'employee_id' =>    'JIO140', 'name' => 'Ramesh Jadam'],
                ['id'=>41 , 'employee_id' =>    'JIO141', 'name' => 'Chaju Bhagat'],
                ['id'=>42 , 'employee_id' =>    'JIO142', 'name' => 'Sita Ram Bagda'],
                ['id'=>43 , 'employee_id' =>    'JIO143', 'name' => 'Sharwan Lodha'],
                ['id'=>44 , 'employee_id' =>    'JIO144', 'name' => 'Bhagirath'],
                ['id'=>45 , 'employee_id' =>    'JIO145', 'name' => 'Rakshita'],
                ['id'=>46 , 'employee_id' =>    'JIO146', 'name' => 'Kavita Choudhary'],
                ['id'=>47 , 'employee_id' =>    'JIO147', 'name' => 'Babulal Jat'],
                ['id'=>48 , 'employee_id' =>    'JIO148', 'name' => 'Ajay Chomu'],
                ['id'=>49 , 'employee_id' =>    'JIO149', 'name' => 'Savita 14no'],
                ['id'=>50 , 'employee_id' =>    'JIO150', 'name' => 'Gyanchand Mandi'],
                ['id'=>51 , 'employee_id' =>    'JIO151', 'name' => 'Kanaram'],
                ['id'=>52 , 'employee_id' =>    'JIO152', 'name' => 'Vikash Chop'],
                ['id'=>53 , 'employee_id' =>    'JIO153', 'name' => 'Banti Mandi'],
                ['id'=>54 , 'employee_id' =>    'JIO154', 'name' => 'Pappu ji Mandi'],
                ['id'=>55 , 'employee_id' =>    'JIO155', 'name' => 'Arjun Ji Prajapat'],
                ['id'=>56 , 'employee_id' =>    'JIO156', 'name' => 'Arun Roa'],
                ['id'=>57 , 'employee_id' =>    'JIO157', 'name' => 'Jitu Saini'],
                ['id'=>58 , 'employee_id' =>    'JIO158', 'name' => 'Tejpal Saini'],
                ['id'=>59 , 'employee_id' =>    'JIO159', 'name' => 'Alok Chohan'],
                ['id'=>60 , 'employee_id' =>    'JIO160', 'name' => 'Krishna devi 14 no'],
                ['id'=>61 , 'employee_id' =>    'JIO161', 'name' => 'Kishan Ji 14 no'],
                ['id'=>62 , 'employee_id' =>    'JIO162', 'name' => 'Raju Lal Singhadiya'],
                ['id'=>63 , 'employee_id' =>    'JIO163', 'name' => 'Sunil Katariya'],
                ['id'=>64 , 'employee_id' =>    'JIO164', 'name' => 'Ashok Khora 14 no Ladkhan'],
                ['id'=>65 , 'employee_id' =>    'JIO165', 'name' => 'Hitesh Saini'],
                ['id'=>66 , 'employee_id' =>    'JIO166', 'name' => 'Pramod Samota'],
                ['id'=>67 , 'employee_id' =>    'JIO167', 'name' => 'Ramkishan Samaota'],
                ['id'=>68 , 'employee_id' =>    'JIO168', 'name' => 'Tejpal Vyapoari Mahroli'],
                ['id'=>69 , 'employee_id' =>    'JIO169', 'name' => 'Sagar Lahar Mahroli'],
                ['id'=>70 , 'employee_id' =>    'JIO170', 'name' => 'KANARAAM Basa'],
                ['id'=>71 , 'employee_id' =>    'JIO171', 'name' => 'Ratan Premnagar'],
                ['id'=>72 , 'employee_id' =>    'JIO172', 'name' => 'Deepak Saini Faal'],
                ['id'=>73 , 'employee_id' =>    'JIO173', 'name' => 'Hari Singh'],
                ['id'=>74 , 'employee_id' =>    'JIO174', 'name' => 'Ramesh Papatwal Chomu'],
                ['id'=>75 , 'employee_id' =>    'JIO175', 'name' => 'Ravi Mandi 14 (II)'],
                ['id'=>76 , 'employee_id' =>    'JIO176', 'name' => 'Sunil Sighadiya'],
                ['id'=>77 , 'employee_id' =>    'JIO177', 'name' => 'Tejpal Singhadiya'],
                ['id'=>78 , 'employee_id' =>    'JIO178', 'name' => 'Ashok & Manvi Yadav'],
                ['id'=>79 , 'employee_id' =>    'JIO179', 'name' => 'Ramprasad Saini PremNagar'],
                ['id'=>80 , 'employee_id' =>    'JIO180', 'name' => 'Rajendra Indora'],
                ['id'=>81 , 'employee_id' =>    'JIO181', 'name' => 'Praveen Chai Wala'],
                ['id'=>82 , 'employee_id' =>    'JIO182', 'name' => 'Raju Yadav Chai Wala( 14no'],
                ['id'=>83 , 'employee_id' =>    'JIO183', 'name' => 'Om Prakash Saini'],
                ['id'=>84 , 'employee_id' =>    'JIO184', 'name' => 'Om Prakash Pawar'],
                ['id'=>85 , 'employee_id' =>    'JIO185', 'name' => 'Nathu Ram Pawar'],
                ['id'=>86 , 'employee_id' =>    'JIO186', 'name' => 'Maliram Pawar'],
                ['id'=>87 , 'employee_id' =>    'JIO187', 'name' => 'Kanhaiya Lal Prajapat'],
                ['id'=>88 , 'employee_id' =>    'JIO188', 'name' => 'Munna Singh Mothu ka'],
                ['id'=>89 , 'employee_id' =>    'JIO189', 'name' => 'Vinod Saini'],
                ['id'=>90 , 'employee_id' =>    'JIO190', 'name' => 'Deepak Sukla'],
                ['id'=>91 , 'employee_id' =>    'JIO191', 'name' => 'Mukesh Samod'],
                ['id'=>92 , 'employee_id' =>    'JIO192', 'name' => 'Namichand singhadiya'],
                ['id'=>93 , 'employee_id' =>    'JIO193', 'name' => 'Anil Sarkar'],
                ['id'=>94 , 'employee_id' =>    'JIO194', 'name' => 'Rakesh Mali'],
                ['id'=>95 , 'employee_id' =>    'JIO195', 'name' => 'Madan Pawar Mothu Ka bas'],
                ['id'=>96 , 'employee_id' =>    'JIO196', 'name' => 'Shankar Kagot'],
                ['id'=>97 , 'employee_id' =>    'JIO197', 'name' => 'Lokesh Panwar'],
                ['id'=>98 , 'employee_id' =>    'JIO198', 'name' => 'Ramdhan Panwar'],
                ['id'=>99 , 'employee_id' =>    'JIO199', 'name' => 'Deepak Saini Hasanpura'],
                ['id'=>100 , 'employee_id' =>   'JIO200', 'name' => 'Jugal Saini Mothu ka bas'],
                ['id'=>101 , 'employee_id' =>   'JIO201', 'name' => 'RK Vegitable Babu Solet'],
                ['id'=>102 , 'employee_id' =>   'JIO202', 'name' => 'Jitendra Katariya'],
                ['id'=>103 , 'employee_id' =>   'JIO203', 'name' => 'Bima Panwar'],
                ['id'=>104 , 'employee_id' =>   'JIO204', 'name' => 'Dilraj Puri'],
                ['id'=>105 , 'employee_id' =>   'JIO205', 'name' => 'Vikram Sen'],
                ['id'=>106 , 'employee_id' =>   'JIO206', 'name' => 'Shayam Lal Nayak'],
                ['id'=>107 , 'employee_id' =>   'JIO207', 'name' => 'Monika Saini'],
                ['id'=>108 , 'employee_id' =>   'JIO208', 'name' => 'Jivraj Sharma'],
                ['id'=>109 , 'employee_id' =>   'JIO209', 'name' => 'Hanuma karodiya'],
                ['id'=>110 , 'employee_id' =>   'JIO210', 'name' => 'Ratan Saini 14 no'],
                ['id'=>111 , 'employee_id' =>   'JIO211', 'name' => 'Babu Fal'],
                ['id'=>112 , 'employee_id' =>   'JIO212', 'name' => 'Shayam Fal'],
                ['id'=>113 , 'employee_id' =>   'JIO213', 'name' => 'Shakti Kapoor'],
                ['id'=>114 , 'employee_id' =>   'JIO214', 'name' => 'Nathi Devi (Arjun Lal)'],
                ['id'=>115 , 'employee_id' =>   'JIO215', 'name' => 'Raju Premnagar'],
                ['id'=>116 , 'employee_id' =>   'JIO216', 'name' => 'Rohitash Prajapat Ladkhani'],
                ['id'=>117 , 'employee_id' =>   'JIO217', 'name' => 'Prakash Sah'],
                ['id'=>118 , 'employee_id' =>   'JIO218', 'name' => 'Mahesh Karodiya'],
                ['id'=>119 , 'employee_id' =>   'JIO219', 'name' => 'Sanjay Kumar bunkar'],
                ['id'=>120 , 'employee_id' =>   'JIO220', 'name' => 'Tejpal saini'],
                ['id'=>121 , 'employee_id' =>   'JIO221', 'name' => 'Kanaram'],
                ['id'=>122 , 'employee_id' =>   'JIO222', 'name' => 'Sitaram saini'],
                ['id'=>123 , 'employee_id' =>   'JIO223', 'name' => 'Sitaram saini'],
                ['id'=>124 , 'employee_id' =>   'JIO224', 'name' => 'Ashwini Sharma'],
                ['id'=>125 , 'employee_id' =>   'JIO225', 'name' => 'Raju Yadav'],
                ['id'=>126 , 'employee_id' =>   'JIO226', 'name' => 'Ramji lal saini'],
                ['id'=>127 , 'employee_id' =>   'JIO227', 'name' => 'Keshav'],
                ['id'=>128 , 'employee_id' =>   'JIO228', 'name' => 'Mukesh'],
                ['id'=>129 , 'employee_id' =>   'JIO229', 'name' => 'Tarachand saini'],
                ['id'=>130 , 'employee_id' =>   'JIO230', 'name' => 'Kalu ram saini'],
                ['id'=>131 , 'employee_id' =>   'JIO231', 'name' => 'Guddu yadav'],
                ['id'=>132 , 'employee_id' =>   'JIO232', 'name' => 'Bihari yadav'],
                ['id'=>133 , 'employee_id' =>   'JIO233', 'name' => 'Guddu yadav'],
                ['id'=>134 , 'employee_id' =>   'JIO234', 'name' => 'Krishan Kumar saini'],
                ['id'=>135 , 'employee_id' =>   'JIO235', 'name' => 'Rakesh Kumar yadav'],
                ['id'=>136 , 'employee_id' =>   'JIO236', 'name' => 'Rahul Sharma'],
                ['id'=>137 , 'employee_id' =>   'JIO237', 'name' => 'Mamaraj Nitharwal'],
                ['id'=>138 , 'employee_id' =>   'JIO238', 'name' => 'Lalita devi'],
                ['id'=>139 , 'employee_id' =>   'JIO239', 'name' => 'kazim'],
                ['id'=>140 , 'employee_id' =>   'JIO240', 'name' => 'kazim'],
                ['id'=>141 , 'employee_id' =>   'JIO241', 'name' => 'Kailash chand saini'],
                ['id'=>142 , 'employee_id' =>   'JIO242', 'name' => 'Nawalkishore'],
                ['id'=>143 , 'employee_id' =>   'JIO243', 'name' => 'Satyanarayan kumawat'],
                ['id'=>144 , 'employee_id' =>   'JIO244', 'name' => 'Mukesh kumar parjapat'],
                ['id'=>145 , 'employee_id' =>   'JIO245', 'name' => 'Nand lal saini'],
                ['id'=>146 , 'employee_id' =>   'JIO246', 'name' => 'Ravi saini'],
                ['id'=>147 , 'employee_id' =>   'JIO247', 'name' => 'Prakash pandit'],
                ['id'=>148 , 'employee_id' =>   'JIO248', 'name' => 'Moolchand yadav'],
                ['id'=>149 , 'employee_id' =>   'JIO249', 'name' => 'Roshan  saini'],
                ['id'=>150 , 'employee_id' =>   'JIO250', 'name' => 'Pool chand saini'],
                ['id'=>151 , 'employee_id' =>   'JIO251', 'name' => 'Mohan sharma'],
                ['id'=>152 , 'employee_id' =>   'JIO252', 'name' => 'Firoz khan'],
                ['id'=>153 , 'employee_id' =>   'JIO253', 'name' => 'Ashok kumawat'],
                ['id'=>154 , 'employee_id' =>   'JIO254', 'name' => 'Sonu neemkathana'],
                ['id'=>155 , 'employee_id' =>   'JIO255', 'name' => 'Dinesh Kumar saini'],
                ['id'=>156 , 'employee_id' =>   'JIO256', 'name' => 'Ashok saini'],
                ['id'=>157 , 'employee_id' =>   'JIO257', 'name' => 'Kalu ram gujar'],
                ['id'=>158 , 'employee_id' =>   'JIO258', 'name' => 'Sanwar mal saini'],
                ['id'=>159 , 'employee_id' =>   'JIO259', 'name' => 'Suresh Kumar Sharma'],
                ['id'=>160 , 'employee_id' =>   'JIO260', 'name' => 'Prahld singh'],
                ['id'=>161 , 'employee_id' =>   'JIO261', 'name' => 'Ramlal saini'],
                ['id'=>162 , 'employee_id' =>   'JIO262', 'name' => 'Nandkishor Swami'],
                ['id'=>163 , 'employee_id' =>   'JIO263', 'name' => 'Sharwan Kumar Saini']];

                foreach($users as $user){
                    $first_two_chars = substr($user['name'], 0, 2);
                    $first_two_chars = strtolower($first_two_chars);
                    $user['name'] = $first_two_chars . '@123456';
                    $empl = User::find($user['id']);
                    $empl->password = $user['name'];
                    $empl->save();
                }
    }

    public function createEmployeeID(){
        $employee_id_prefix = "JIO";
        $employee_id_number = 101;

        $user = User::orderBy('id', 'desc')->first();

        if ($user) {
            $last_employee_id_number = (int) substr($user->employee_id, strlen($employee_id_prefix));
            $employee_id_number = $last_employee_id_number + 1;
        }

        $employee_id = $employee_id_prefix . $employee_id_number;

        return $employee_id;
    }
}
