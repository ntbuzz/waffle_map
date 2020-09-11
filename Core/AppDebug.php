<?php
/* -------------------------------------------------------------
 * PHPフレームワーク
 *  AppDebug:    デバッグ用のメッセージ出力クラス
 */

const EMPTY_MSG = " EMPTY\n";

/*
    アプリケーションデバッグ情報
*/
class APPDEBUG {
    private static $MsgLevel;          // 出力メッセージレベル
    private static $RunTime;           // 測定開始時刻
    public static $LevelMsg;           // レベルメッセージの配列

    //==========================================================================
    // メッセージ出力レベルの設定
    public static function INIT($lvl){
        self::$MsgLevel = $lvl;
        self::$LevelMsg = array('');
    }
    //==========================================================================
    // 実行時間測定開始
    public static function RUN_START() {
        self::$RunTime = microtime(TRUE);
    }
    //==========================================================================
    // 実行時間表示
    public static function RUN_FINISH($lvl) {
        $tm = round((microtime(TRUE) - self::$RunTime), 2);     // 少数2位まで
        $maxmem = round(memory_get_peak_usage()/(1024*1024),2);
//        self::LOG($lvl,[
        self::LOG($lvl,[
                "実行時間" => "{$tm} 秒",
            "メモリ消費" => "最大: {$maxmem} MB",
        ]);
    }
    //==========================================================================
    // バックトレースから呼び出し元の情報を取得
    private static function backtraceinfo($stop=FALSE){
        $dbinfo = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT,3);    // 呼び出し元のスタックまでの数
        if($stop) { 
            echo "TYPE:".get_class($dbinfo[2]['object'])."\n";
            var_dump($dbinfo[2]['object']);
            exit;
        }
        $dbpath = str_replace('\\','/',$dbinfo[1]['file']);             // Windowsパス対策
        list($pp,$fn) = extract_path_filename($dbpath);
        $fn .= "(".$dbinfo[1]['line'].")";
        if(isset($dbinfo[2]['object'])) {
            $pp = get_class($dbinfo[2]['object']);  // 呼出し元のクラス名
            if(substr($fn,0,strlen($pp)) !== $pp) $fn = "{$pp}::{$fn}";
        }
        $str = "{$fn}->" . $dbinfo[2]['function'];
        return $str;
    }
    //==========================================================================
    // メッセージ要素の並替え
    public static function LOG_SORT() {
        ksort( self::$LevelMsg );
    }
    //==============================================================================
    //  ログ出力
    //
    public static function LOG($lvl,...$items) {
        if(!DEBUGGER) return;
        $info = self::backtraceinfo($lvl > 100);
        self::dbEcho($lvl, "<pre>\n{$info}\n");
        foreach($items as $arg) {
            if(is_scalar($arg)) {
                if(empty($arg)) $arg ='NULL'; else $arg= wordwrap($arg,86,"\n");
                self::dbEcho($lvl,"{$arg}\n");
            } else if(is_array($arg)) {                        // 配列要素の出力
                foreach($arg as $msg => $obj) {
                    if(is_scalar($obj)) {
                        self::dbEcho($lvl, "{$msg} : {$obj}\n");
                    } else {
                        self::dbEcho($lvl, "===== {$msg} =====\n");
                        if(empty($obj)) self::dbEcho($lvl,EMPTY_MSG);
                        else self::dumpObject($obj,0, $lvl);
                        self::dbEcho($lvl,"\n");
                    }
                }
            }
        }
        self::dbEcho($lvl, "\n</pre>\n");
    }
    //==========================================================================
    // メッセージ登録
    private static function dbEcho($lvl,$msg,$is_safe = FALSE) {
        if(empty($msg)) return;
        if($is_safe && !empty($msg)) $msg = htmlspecialchars($msg);
        if($lvl < 0) {
            echo $msg;
        } else if($lvl < self::$MsgLevel) {
            if(isset(self::$LevelMsg[$lvl])) self::$LevelMsg[$lvl] .= $msg;
            else self::$LevelMsg[$lvl] = $msg;
        }
    }
    //==========================================================================
    // 配列のダンプ
    private static function dumpObject($obj,$indent,$level){
        if(is_array($obj)) {    // 配列出力
        foreach($obj as $key => $val) {
            self::dbEcho($level, str_repeat(' ',$indent*2) . "[{$key}] = ");
            if($val == NULL) {
                self::dbEcho($level, "NULL\n");
            } else if(is_scalar($val)) {
                self::dbEcho($level, "'{$val}'\n",TRUE);
            } else if(is_array($val)) {
                self::dbEcho($level, "array(" . count($val) . ")\n");
                self::dumpObject($val,$indent+1,$level);
            } else {
                self::dbEcho($level, gettype($val) . "\n",TRUE);
            }
            }
        } else if(is_scalar($obj)) {    // スカラー出力
            self::dbEcho($level, $obj,TRUE);
        } else {
            self::dbEcho($level, 'UNKNOW $obj',TRUE);
        }
    }
}
