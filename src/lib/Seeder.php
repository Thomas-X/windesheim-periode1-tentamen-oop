<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 25/10/18
 * Time: 02:39
 */

namespace Qui\lib;

use Qui\lib\facades\Authentication;
use Qui\lib\facades\DB;
use Qui\lib\facades\DB_PDO;

/*
 * A seeder for when the project needs something seeded.
 * */
class Seeder
{
    public static $faker;
    public static $total = 0;
    public static $totalDone = 0;

    /*
     * stolen from: https://stackoverflow.com/a/27147177
     * prints a fancy progress bar
     * */
    private static function progressBar($done, $total)
    {
        $perc = floor(($done / $total) * 100);
        $left = 100 - $perc;
        $write = sprintf("\033[0G\033[2K[%'={$perc}s>%-{$left}s] - $perc%% - $done/$total", "", "");
        fwrite(STDERR, $write);
    }

    private static function run_seed($factory, $postRun = '')
    {
        $sqlStatements = $factory();
        foreach ($sqlStatements as $sqlStatement) {
            DB::execute($sqlStatement, []);
            if ($postRun != '' && $postRun != null) {
                $postRun(DB_PDO::lastInsertId());
            }
            Seeder::progressBar(Seeder::$totalDone, Seeder::$total);
        }
    }

    // a factory that creates a .. factory??! madness!
    private static function factory_generator($templateGenerator, $fields, $table, $howMany = 1000)
    {
        $arr = [];
        DB::execute("DELETE FROM {$table}");
        for ($i = 0; $i < $howMany; $i++) {
            $val = $templateGenerator();
            $str = '';
            foreach ($val as $idx => $item) {
                if (array_search($idx, array_keys($val)) == (count(array_keys($val)) - 1)) {
//                    $str .= $table === 'users' ? "\"\"" : "\"{$item}\"";
                    $str .= "\"{$item}\"";
                } else {
                    $str .= "\"{$item}\",";
                }
            }
            $arr[] = "INSERT INTO `{$table}` ({$fields}) VALUES ({$str})";
        }
        return $arr;
    }

    public static function seed($shouldRun)
    {
        if (!$shouldRun) {
            return 'fail';
        }
        $faker = \Faker\Factory::create();
        Seeder::$faker = $faker;
        try {
            // Seed logic / data
            function printToConsole($name)
            {
                echo PHP_EOL . PHP_EOL . "starting {$name} seed.." . PHP_EOL . PHP_EOL;
            }
            $range = [51, 1500];

            echo printToConsole("user");
            static::users($faker->numberBetween(...$range));

        } catch (\Exception $exception) {
            return $exception;
        }
        return 'success';
    }

    // Could be done better without copy pasta. But cant be bothered since this is seed
    public static function users($howMany)
    {
        DB::execute('DELETE FROM profiles');
        $faker = Seeder::$faker;
        // because 1:1 1 user 1 profile
        Seeder::$total = $howMany;
        Seeder::$totalDone = 0;
        $factory = function () use ($faker, $howMany) {
            return static::factory_generator(function () use ($faker) {
                Seeder::$totalDone += 1;
                return [
                    'email' => $faker->firstName,
                    'password' => Authentication::generateRandomString(),
                    'rememberMeToken' => Authentication::generateRandomString(),
                    'forgotPasswordToken' => "",
                ];
            }, "`email`, `password`, `rememberMeToken`, `forgotPasswordToken`", 'users', $howMany);
        };
        static::run_seed($factory);
    }
}