<?php
/**
 * Note: Index
 * User: Liu
 * Date: 2017/2/7
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Repositories\BookRepository;
use App\Repositories\BookChapterRepository;

class IndexController extends BaseController
{

    public function getIndex(BookRepository $bookRepository, BookChapterRepository $bookChapterRepository)
    {
        $envs = [
            ['name' => 'PHP version',       'value' => 'PHP/'.PHP_VERSION],
            ['name' => 'Laravel version',   'value' => app()->version()],
            ['name' => 'CGI',               'value' => php_sapi_name()],
            ['name' => 'Uname',             'value' => php_uname()],
            ['name' => 'Server',            'value' => array_get($_SERVER, 'SERVER_SOFTWARE')],
            ['name' => 'Cache driver',      'value' => config('cache.default')],
            ['name' => 'Session driver',    'value' => config('session.driver')],
            ['name' => 'Queue driver',      'value' => config('queue.default')],
            ['name' => 'Timezone',          'value' => config('app.timezone')],
            ['name' => 'Locale',            'value' => config('app.locale')],
            ['name' => 'Env',               'value' => config('app.env')],
            ['name' => 'URL',               'value' => config('app.url')],
        ];
        $counts = \Cache::remember('admin.index.count', 10, function () use ($bookRepository, $bookChapterRepository) {
            $counts = [
                'bookDailyInsert' => $bookRepository->dailyInsertCount(),
                'bookDailyUpdate' => $bookRepository->dailyUpdateCount(),
                'bookTotalCount' => $bookRepository->count(),
                'chapterDailyCount' => $bookChapterRepository->dailyInsertCount(),
                'chapterTotalCount' => $bookChapterRepository->count(),
                'jobCount' => \DB::table('jobs')->count()
            ];
            $counts['chapterInsertPrecent'] = $counts['chapterDailyCount'] ? sprintf('%.3f', ($counts['chapterDailyCount'] / ($counts['chapterTotalCount'] - $counts['chapterDailyCount']))) : 0;
            return $counts;
        });
        $data = [
            'envs'  => $envs,
            'counts'=> $counts
        ];
        return view('admin.index', $data);
    }

    public function postIndex()
    {
        return $this->sysinfo();
    }

    protected function sysinfo()
    {
        switch(PHP_OS)
        {
            case "Linux":
                $sysInfo = $this->sys_linux();
                break;

            case "FreeBSD":
                $sysInfo = $this->sys_freebsd();
                break;
                case "WINNT":
                    $sysInfo = $this->sys_windows();
                break;
            default:
                break;
        }
//        $stat1 = $this->GetCoreInformation();
//        sleep(1);
//        $stat2 = $this->GetCoreInformation();
//        $data = $this->GetCpuPercentages($stat1, $stat2);
//        $sysInfo['cpu_show'] = $data['cpu0']['user'] . "%us,  " . $data['cpu0']['sys'] . "%sy,  " . $data['cpu0']['nice'] . "%ni, " . $data['cpu0']['idle'] . "%id,  " . $data['cpu0']['iowait'] . "%wa,  " . $data['cpu0']['irq'] . "%irq,  " . $data['cpu0']['softirq'] . "%softirq";

        $sysInfo['cpuPercent'] = $this->getCpu();
        //$sysInfo['uptime'] = $sysInfo['uptime']; //在线时间
        $stime = date('Y-m-d H:i:s'); //系统当前时间

        //硬盘
        $dt = round(@disk_total_space(".")/(1024*1024*1024),3); //总
        $df = round(@disk_free_space(".")/(1024*1024*1024),3); //可用
        $du = $dt-$df; //已用
        $sysInfo['hdTotal'] = $dt . 'G';
        $sysInfo['hdCanUse'] = $df . 'G';
        $sysInfo['hdUse'] = $du . 'G';

        $sysInfo['hdPercent'] = (floatval($dt)!=0)?round($du/$dt*100,2):0;

        //$load = $sysInfo['loadAvg'];	//系统负载


        //判断内存如果小于1G，就显示M，否则显示G单位
        if($sysInfo['memTotal']<1024)
        {
            //sysInfo['memTotal'] = $sysInfo['memTotal']." M";
            $sysInfo['memTotal'] = $sysInfo['memTotal']." M";
            $sysInfo['memUsed'] = $sysInfo['memUsed']." M";
            $sysInfo['memFree'] = $sysInfo['memFree']." M";
            $sysInfo['memCached'] = $sysInfo['memCached']." M";	//cache化内存
            $sysInfo['memBuffers'] = $sysInfo['memBuffers']." M";	//缓冲
            $sysInfo['swapTotal'] = $sysInfo['swapTotal']." M";
            $sysInfo['swapUsed'] = $sysInfo['swapUsed']." M";
            $sysInfo['swapFree'] = $sysInfo['swapFree']." M";
            //$swapPercent = $sysInfo['swapPercent'];
            $sysInfo['memRealUsed'] = $sysInfo['memRealUsed']." M"; //真实内存使用
            $sysInfo['memRealFree'] = $sysInfo['memRealFree']." M"; //真实内存空闲
            //$sysInfo['memRealPercent'] = $sysInfo['memRealPercent']; //真实内存使用比率
            //$memPercent = $sysInfo['memPercent']; //内存总使用率
            //$memCachedPercent = $sysInfo['memCachedPercent']; //cache内存使用率
        }
        else
        {
            $sysInfo['memTotal'] = round($sysInfo['memTotal']/1024,3)." G";
            $sysInfo['memTotal'] = round($sysInfo['memTotal']/1024,3)." G";
            $sysInfo['memUsed'] = round($sysInfo['memUsed']/1024,3)." G";
            $sysInfo['memFree'] = round($sysInfo['memFree']/1024,3)." G";
            $sysInfo['memCached'] = round($sysInfo['memCached']/1024,3)." G";
            $sysInfo['memBuffers'] = round($sysInfo['memBuffers']/1024,3)." G";
            $sysInfo['swapTotal'] = round($sysInfo['swapTotal']/1024,3)." G";
            $sysInfo['swapUsed'] = round($sysInfo['swapUsed']/1024,3)." G";
            $sysInfo['swapFree'] = round($sysInfo['swapFree']/1024,3)." G";
            //$swapPercent = $sysInfo['swapPercent'];
            $sysInfo['memRealUsed'] = round($sysInfo['memRealUsed']/1024,3)." G"; //真实内存使用
            $sysInfo['memRealFree'] = round($sysInfo['memRealFree']/1024,3)." G"; //真实内存空闲
            //$memRealPercent = $sysInfo['memRealPercent']; //真实内存使用比率
            //$memPercent = $sysInfo['memPercent']; //内存总使用率
            //$memCachedPercent = $sysInfo['memCachedPercent']; //cache内存使用率
        }
        $sysInfo['time'] = date('H:i:s');
        return $sysInfo;
    }

    //linux系统探测
    protected function sys_linux()
    {
        // CPU
        if (false === ($str = @file("/proc/cpuinfo"))) return false;
        $str = implode("", $str);
        @preg_match_all("/model\s+name\s{0,}\:+\s{0,}([\w\s\)\(\@.-]+)([\r\n]+)/s", $str, $model);
        @preg_match_all("/cpu\s+MHz\s{0,}\:+\s{0,}([\d\.]+)[\r\n]+/", $str, $mhz);
        @preg_match_all("/cache\s+size\s{0,}\:+\s{0,}([\d\.]+\s{0,}[A-Z]+[\r\n]+)/", $str, $cache);
        @preg_match_all("/bogomips\s{0,}\:+\s{0,}([\d\.]+)[\r\n]+/", $str, $bogomips);
        if (false !== is_array($model[1]))
        {
            $res['cpu']['num'] = sizeof($model[1]);

            for($i = 0; $i < $res['cpu']['num']; $i++)
            {
//                $res['cpu']['model'][] = $model[1][$i].'&nbsp;('.$mhz[1][$i].')';
                $res['cpu']['mhz'][] = $mhz[1][$i];
                $res['cpu']['cache'][] = $cache[1][$i];
                $res['cpu']['bogomips'][] = $bogomips[1][$i];
            }
            if($res['cpu']['num']==1)
                $x1 = '';
            else
                $x1 = ' ×'.$res['cpu']['num'];
            $mhz[1][0] = ' | 频率:'.$mhz[1][0];
            $cache[1][0] = ' | 二级缓存:'.$cache[1][0];
            $bogomips[1][0] = ' | Bogomips:'.$bogomips[1][0];
            $res['cpu']['model'][] = $model[1][0].$mhz[1][0].$cache[1][0].$bogomips[1][0].$x1;
            if (false !== is_array($res['cpu']['model'])) $res['cpu']['model'] = implode("<br />", $res['cpu']['model']);
            if (false !== is_array($res['cpu']['mhz'])) $res['cpu']['mhz'] = implode("<br />", $res['cpu']['mhz']);
            if (false !== is_array($res['cpu']['cache'])) $res['cpu']['cache'] = implode("<br />", $res['cpu']['cache']);
            if (false !== is_array($res['cpu']['bogomips'])) $res['cpu']['bogomips'] = implode("<br />", $res['cpu']['bogomips']);
        }

        // NETWORK

        // UPTIME
        if (false === ($str = @file("/proc/uptime"))) return false;
        $str = explode(" ", implode("", $str));
        $str = trim($str[0]);
        $min = $str / 60;
        $hours = $min / 60;
        $days = floor($hours / 24);
        $hours = floor($hours - ($days * 24));
        $min = floor($min - ($days * 60 * 24) - ($hours * 60));
        if ($days !== 0) $res['uptime'] = $days."天";
        if ($hours !== 0) $res['uptime'] .= $hours."小时";
        $res['uptime'] .= $min."分钟";

        // MEMORY
        if (false === ($str = @file("/proc/meminfo"))) return false;
        $str = implode("", $str);
        preg_match_all("/MemTotal\s{0,}\:+\s{0,}([\d\.]+).+?MemFree\s{0,}\:+\s{0,}([\d\.]+).+?Cached\s{0,}\:+\s{0,}([\d\.]+).+?SwapTotal\s{0,}\:+\s{0,}([\d\.]+).+?SwapFree\s{0,}\:+\s{0,}([\d\.]+)/s", $str, $buf);
        preg_match_all("/Buffers\s{0,}\:+\s{0,}([\d\.]+)/s", $str, $buffers);

        $res['memTotal'] = round($buf[1][0]/1024, 2);
        $res['memFree'] = round($buf[2][0]/1024, 2);
        $res['memBuffers'] = round($buffers[1][0]/1024, 2);
        $res['memCached'] = round($buf[3][0]/1024, 2);
        $res['memUsed'] = $res['memTotal']-$res['memFree'];
        $res['memPercent'] = (floatval($res['memTotal'])!=0)?round($res['memUsed']/$res['memTotal']*100,2):0;

        $res['memRealUsed'] = $res['memTotal'] - $res['memFree'] - $res['memCached'] - $res['memBuffers']; //真实内存使用
        $res['memRealFree'] = $res['memTotal'] - $res['memRealUsed']; //真实空闲
        $res['memRealPercent'] = (floatval($res['memTotal'])!=0)?round($res['memRealUsed']/$res['memTotal']*100,2):0; //真实内存使用率

        $res['memCachedPercent'] = (floatval($res['memCached'])!=0)?round($res['memCached']/$res['memTotal']*100,2):0; //Cached内存使用率

        $res['swapTotal'] = round($buf[4][0]/1024, 2);
        $res['swapFree'] = round($buf[5][0]/1024, 2);
        $res['swapUsed'] = round($res['swapTotal']-$res['swapFree'], 2);
        $res['swapPercent'] = (floatval($res['swapTotal'])!=0)?round($res['swapUsed']/$res['swapTotal']*100,2):0;

        // LOAD AVG
        if (false === ($str = @file("/proc/loadavg"))) return false;
        $str = explode(" ", implode("", $str));
        $str = array_chunk($str, 4);
        $res['loadAvg'] = implode(" ", $str[0]);

        return $res;
    }

    //FreeBSD系统探测
    protected function sys_freebsd()
    {
        //CPU
        if (false === ($res['cpu']['num'] = get_key("hw.ncpu"))) return false;
        $res['cpu']['model'] = get_key("hw.model");
        //LOAD AVG
        if (false === ($res['loadAvg'] = get_key("vm.loadavg"))) return false;
        //UPTIME
        if (false === ($buf = get_key("kern.boottime"))) return false;
        $buf = explode(' ', $buf);
        $sys_ticks = time() - intval($buf[3]);
        $min = $sys_ticks / 60;
        $hours = $min / 60;
        $days = floor($hours / 24);
        $hours = floor($hours - ($days * 24));
        $min = floor($min - ($days * 60 * 24) - ($hours * 60));
        if ($days !== 0) $res['uptime'] = $days."天";
        if ($hours !== 0) $res['uptime'] .= $hours."小时";
        $res['uptime'] .= $min."分钟";
        //MEMORY
        if (false === ($buf = get_key("hw.physmem"))) return false;
        $res['memTotal'] = round($buf/1024/1024, 2);

        $str = get_key("vm.vmtotal");
        preg_match_all("/\nVirtual Memory[\:\s]*\(Total[\:\s]*([\d]+)K[\,\s]*Active[\:\s]*([\d]+)K\)\n/i", $str, $buff, PREG_SET_ORDER);
        preg_match_all("/\nReal Memory[\:\s]*\(Total[\:\s]*([\d]+)K[\,\s]*Active[\:\s]*([\d]+)K\)\n/i", $str, $buf, PREG_SET_ORDER);

        $res['memRealUsed'] = round($buf[0][2]/1024, 2);
        $res['memCached'] = round($buff[0][2]/1024, 2);
        $res['memUsed'] = round($buf[0][1]/1024, 2) + $res['memCached'];
        $res['memFree'] = $res['memTotal'] - $res['memUsed'];
        $res['memPercent'] = (floatval($res['memTotal'])!=0)?round($res['memUsed']/$res['memTotal']*100,2):0;

        $res['memRealPercent'] = (floatval($res['memTotal'])!=0)?round($res['memRealUsed']/$res['memTotal']*100,2):0;

        return $res;
    }


    //windows系统探测
    protected function sys_windows()
    {
        if (PHP_VERSION >= 5)
        {
            $objLocator = new \COM("WbemScripting.SWbemLocator");
            $wmi = $objLocator->ConnectServer();
            $prop = $wmi->get("Win32_PnPEntity");
        }
        else
        {
            return false;
        }

        //CPU
        $cpuinfo = $this->GetWMI($wmi,"Win32_Processor", array("Name","L2CacheSize","NumberOfCores"));
        $res['cpu']['num'] = $cpuinfo[0]['NumberOfCores'];
        if (null == $res['cpu']['num'])
        {
            $res['cpu']['num'] = 1;
        }/*
	for ($i=0;$i<$res['cpu']['num'];$i++)
	{
		$res['cpu']['model'] .= $cpuinfo[0]['Name']."<br />";
		$res['cpu']['cache'] .= $cpuinfo[0]['L2CacheSize']."<br />";
	}*/
        $cpuinfo[0]['L2CacheSize'] = ' ('.$cpuinfo[0]['L2CacheSize'].')';
        if($res['cpu']['num']==1)
            $x1 = '';
        else
            $x1 = ' ×'.$res['cpu']['num'];
        $res['cpu']['model'] = $cpuinfo[0]['Name'].$cpuinfo[0]['L2CacheSize'].$x1;
        // SYSINFO
        $sysinfo = $this->GetWMI($wmi,"Win32_OperatingSystem", array('LastBootUpTime','TotalVisibleMemorySize','FreePhysicalMemory','Caption','CSDVersion','SerialNumber','InstallDate'));
        $sysinfo[0]['Caption']=iconv('GBK', 'UTF-8',$sysinfo[0]['Caption']);
        $sysinfo[0]['CSDVersion']=iconv('GBK', 'UTF-8',$sysinfo[0]['CSDVersion']);
        $res['win_n'] = $sysinfo[0]['Caption']." ".$sysinfo[0]['CSDVersion']." 序列号:{$sysinfo[0]['SerialNumber']} 于".date('Y年m月d日H:i:s',strtotime(substr($sysinfo[0]['InstallDate'],0,14)))."安装";
        //UPTIME
        $res['uptime'] = $sysinfo[0]['LastBootUpTime'];

        $sys_ticks = 3600*8 + time() - strtotime(substr($res['uptime'],0,14));
        $min = $sys_ticks / 60;
        $hours = $min / 60;
        $days = floor($hours / 24);
        $hours = floor($hours - ($days * 24));
        $min = floor($min - ($days * 60 * 24) - ($hours * 60));
        if ($days !== 0) $res['uptime'] = $days."天";
        if ($hours !== 0) $res['uptime'] .= $hours."小时";
        $res['uptime'] .= $min."分钟";

        //MEMORY
        $res['memTotal'] = round($sysinfo[0]['TotalVisibleMemorySize']/1024,2);
        $res['memFree'] = round($sysinfo[0]['FreePhysicalMemory']/1024,2);
        $res['memUsed'] = $res['memTotal']-$res['memFree'];	//上面两行已经除以1024,这行不用再除了
        $res['memPercent'] = round($res['memUsed'] / $res['memTotal']*100,2);

        $swapinfo = $this->GetWMI($wmi,"Win32_PageFileUsage", array('AllocatedBaseSize','CurrentUsage'));

        // LoadPercentage
        $loadinfo = $this->GetWMI($wmi,"Win32_Processor", array("LoadPercentage"));
        $res['loadAvg'] = $loadinfo[0]['LoadPercentage'];

        return $res;
    }

    protected function GetWMI($wmi,$strClass, $strValue = array())
    {
        $arrData = array();

        $objWEBM = $wmi->Get($strClass);
        $arrProp = $objWEBM->Properties_;
        $arrWEBMCol = $objWEBM->Instances_();
        foreach($arrWEBMCol as $objItem)
        {
            @reset($arrProp);
            $arrInstance = array();
            foreach($arrProp as $propItem)
            {
                eval("\$value = \$objItem->" . $propItem->Name . ";");
                if (empty($strValue))
                {
                    $arrInstance[$propItem->Name] = trim($value);
                }
                else
                {
                    if (in_array($propItem->Name, $strValue))
                    {
                        $arrInstance[$propItem->Name] = trim($value);
                    }
                }
            }
            $arrData[] = $arrInstance;
        }
        return $arrData;
    }


    protected function GetCoreInformation()
    {
        $data = file('/proc/stat');
        $cores = array();
        foreach ($data as $line) {
            if (preg_match('/^cpu[0-9]/', $line)) {
                $info = explode(' ', $line);
                $cores[] = array('user' => $info[1], 'nice' => $info[2], 'sys' => $info[3], 'idle' => $info[4], 'iowait' => $info[5], 'irq' => $info[6], 'softirq' => $info[7]);
            }
        }
        return $cores;
    }


    protected function getCpu()
    {
        $mode = "/(cpu)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)[\s]+([0-9]+)/";
        $string=shell_exec("more /proc/stat");
        preg_match_all($mode,$string,$arr);
        //print_r($arr);
        $total1=$arr[2][0]+$arr[3][0]+$arr[4][0]+$arr[5][0]+$arr[6][0]+$arr[7][0]+$arr[8][0]+$arr[9][0];
        $time1=$arr[2][0]+$arr[3][0]+$arr[4][0]+$arr[6][0]+$arr[7][0]+$arr[8][0]+$arr[9][0];

        sleep(1);
        $string=shell_exec("more /proc/stat");
        preg_match_all($mode,$string,$arr);
        $total2=$arr[2][0]+$arr[3][0]+$arr[4][0]+$arr[5][0]+$arr[6][0]+$arr[7][0]+$arr[8][0]+$arr[9][0];
        $time2=$arr[2][0]+$arr[3][0]+$arr[4][0]+$arr[6][0]+$arr[7][0]+$arr[8][0]+$arr[9][0];
        $time=$time2-$time1;
        $total=$total2-$total1;
        //echo "CPU amount is: ".$num;
        $percent=bcdiv($time,$total,3);
        $percent=$percent*100;
        return $percent;
    }

    protected function GetCpuPercentages($stat1, $stat2)
    {
        if (count($stat1) !== count($stat2)) {
            return;
        }
        $cpus = array();
        for ($i = 0, $l = count($stat1); $i < $l; $i++) {
            $dif = array();
            $dif['user'] = $stat2[$i]['user'] - $stat1[$i]['user'];
            $dif['nice'] = $stat2[$i]['nice'] - $stat1[$i]['nice'];
            $dif['sys'] = $stat2[$i]['sys'] - $stat1[$i]['sys'];
            $dif['idle'] = $stat2[$i]['idle'] - $stat1[$i]['idle'];
            $dif['iowait'] = $stat2[$i]['iowait'] - $stat1[$i]['iowait'];
            $dif['irq'] = $stat2[$i]['irq'] - $stat1[$i]['irq'];
            $dif['softirq'] = $stat2[$i]['softirq'] - $stat1[$i]['softirq'];
            $total = array_sum($dif);
            $cpu = array();
            foreach ($dif as $x => $y) $cpu[$x] = round($y / $total * 100, 2);
            $cpus['cpu' . $i] = $cpu;
        }
        return $cpus;
    }
}