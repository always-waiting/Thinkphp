<?php
/**
 * Created by PhpStorm.
 * User: mixichao
 * Date: 2017/9/19
 * Time: 18:35
 */

namespace app\Database\model;



use think\Exception;
use think\Model;
class CPUException extends \Exception{}
class MEMException extends \Exception{}
class HardNumberException extends \Exception {}
class HardSizesException extends \Exception {}

class HardDevicesInfo extends Model
{
    private $_trim_cpu = NULL;
    private $_trim_memory = NULL;
    private $_total_hard = NULL;
    private $_hard_number = NULL;
    /**
     * @var array
     * 需要配置套餐-类型字典
     * 一个字典数组，有2级键
     * 第一级为cpu型号，例如2620v4
     *      第二级为内存大小，例如64G
     *          存储内容为一个二维数组结构如下：
     *              每行为一个套餐-类型，介绍每列内容
     *                  1: 硬盘总数
     *                  2：硬盘总空间（以GB为单位）
     *                  3：定型配置
     *                  4：套餐名
     *                  5：服务器模型
     *              例如
     *              [
     *                 [18,20260.8,'2*2620v4/64G/16*1.2T SAS+2*300G SAS/2*1G+2*10G','B11','存储型'],
     *                 [14,49752,'2*2620v4/64G/12*4T SATA+2*300G SAS/2*1G+2*10G','B12','存储型'],
     *              ]
     */
    public static $combo_type_hash = array(
        "E3-1585v5" => array(
            32 => array(
                2 => array(
                    960 => array("E3-1585v5/32G/2*480G SSD/2*10G", "N12", "通用型"),
                    4000 => array("E3-1585v5/32G/2*2TB SATA/2*10G", "视频转码-A", "通用型"),
                ),
            ),
        ),
        "E5-2620v4" => array(
            128 => array(
                4 => array(
                    3840 => array("2*2620v4/128G/4*960G SSD/2*1G", "E13", "通用型"),
                    1200 => array("2*2620v4/128G/4*300G SAS+R/2*1G+2*10G", "E12/E19", "通用型"),
                ),
                10 => array(
                    7000 => array(
                        array("2*2620v4/128G/8*800G SSD+2*300G SAS+R/2*1G+2*10G", "D11", "通用型"),
                        array("2*2620v4/128G/8*800G SSD+2*300G SAS+R/2*10G", "云数据库-B", "通用型"),
                    ),
                    8280 => array("2*2620v4/128G/8*960G SSD+2*300G SAS+R/2*1G+2*10G", "D12", "通用型"),
                ),
                12 => array(
                    19800 => array("2*2620v4/128G/2*300G SAS+10*1.92T SSD/4*10G", "B17", "存储型"),
                ),
                14 => array(
                    15000 => array("2*2620v4/128G/12*1.2T SAS+2*300G SAS+R/2*1G+2*10G", "B13", "存储型"),
                    72600 => array(
                        array("2*2620v4/128G/12*6T SATA+2*300G SAS/4*10G", "B16", "存储型"),
                        array("2*2620v4/128G/12*6T SATA+2*300G SAS/2*10G", "云存储-A", "存储型"),
                    ),
                    19800 => array("2*2620v4/128G/2*300G SAS+12*1.6T SSD/4*10G", "云硬盘-C", "存储型"),
                    48600 => array("2*2620v4/128G/2*300G SAS+12*4T SATA/4*10G", "云硬盘-D", "存储型"),
                ),
                22 => array(
                    19800 => array("2*2620v4/128G/2*300G SAS+20*960G SSD/4*10G","B120","存储型"),
                ),
                23 => array(
                    21800 => array("2*2620v4/128G/2*300G SAS+20*960G SSD+2T NVMe/4*10G", "B18", "存储型"),
                ),
            ),
            256 => array(
                4 => array(
                    1200 => array("2*2620v4/256G/4*300G SAS+R/2*1G+2*10G","M12/大内存-D", "内存型/通用型"),
                    3200 => array("2*2620v4/256G/4*800G SSD+R/2*10G", "云缓存-A", "通用型"),
                ),
                6 => array(
                    4440 => array("2*2620v4/256G/4*960G SSD+2*300G SAS+R/6*10G","N11","通用型"),
                    3800 => array("2*2620v4/256G/4*800G SSD+2*300G SAS/2*10G", "CDN-A", "通用型"),
                ),
                14 => array(
                    72600 => array("2*2620v4/256G/12*6T SATA+2*300G SAS/2*1G+2*10G-4PCIE", "B19", "存储型"),
                    12120 => array(
                        array("2*2620v4/256G/12*960G SSD+2*300G SAS+R/2*1G+2*10G", "D13", "存储型"),
                        array("2*2620v4/256G/12*960G SSD+2*300G SAS+R/2*1G+2*10G+2*16Gb HBA", "E124", "存储型"),
                    ),
                ),
            ),
            512 => array(
                4 => array(
                    1200 => array("2*2620v4/512G/4*300G SAS+R/2*1G+2*10G", "M11", "内存型"),
                ),
                6 => array(
                    4440 => array(
                        array("2*2620v4/512G/4*960G SSD+2*300G SAS/4*10G","E122","内存型"),
                        array("2*2620v4/512G/4*960G SSD+2*300G SAS/6*10G", "E123", "内存型"),
                    ),
                ),
            ),
            64 => array(
                4 => array(
                    1200 => array(
                        array("1*2620v4/64G/4*300G SAS+R/2*1G", "E11/仓储应用-A", "通用型"),
                        array("2*2620v4/64G/4*300G SAS+R/2*1G+2*10G", "E14/基本-D", "通用型"),
                    ),
                ),
                8 => array(
                    37600 => array("2*2620v4/64G/2*800G SSD + 6*6TB SATA/2*1G+4*10G", "E115", "存储型"),
                    4200 => array("2*2620v4/64G/6*600GB SAS+2*300G SAS+R/2*1G+2*10G", "E18", "通用型"),
                    7680 => array("2*2620v4/64G/8*960G SSD/2*1G", "E15", "存储型"),
                ),
                14 => array(
                    48600 => array("2*2620v4/64G/12*4T SATA+2*300G SAS/2*1G+2*10G", "B12/存储-C", "存储型"),
                ),
                18 => array(
                    19800 => array("2*2620v4/64G/16*1.2T SAS+2*300G SAS/2*1G+2*10G", "B11/存储-B", "存储型"),
                ),
            ),
        ),
        "E5-2640v3" => array(
            128 => array(
                4 => array(
                    3200 => array("2*2640v3/128G/4*800G SSD/2*1G", "仓储数据库-A", "通用型"),
                    2400 => array("2*E5-2640v3/128G/4*600GB 15K SAS+R/4*1G", "E112", "通用型"),
                ),
                10 => array(
                    7000 => array("2*2640v3/128G/8*800G SSD+2*300G SAS+R/2*1G+2*10G","数据库-A","通用型"),
                ),
            ),
            256 => array(
                14 => array(
                    10200 => array("2*2640v3/256G/12*800G SSD+2*300G SAS+R/2*1G+2*10G", "大数据-J", "通用型"),
                ),
            ),
            64 => array(
                4 => array(
                    2400 => array("2*E5-2640v3/64G/4*600GB 15K SAS+R/4*1G", "E111", "通用型"),
                ),
                8 => array(
                    6400 => array("2*2640v3/64G/8*800G SSD+R/2*1G", "仓储数据库-B", "通用型"),
                ),
            ),
        ),
        "E5-2640v4" => array(
            128 => array(
                4 => array(
                    16000 => array("2*2640v4/128G/4*4T SATA/2*1G+2*10G/4*P4", "GPU-G", "通用型"),
                    3200 => array("2*E5-2640v4/128G/4*800G SSD+R/2*1G+4*10G", "E114", "通用型"),
                ),
            ),
            256 => array(
                4 => array(
                    16000 => array("2*2640v4/256G/4*4T SATA/2*1G+2*10G/4*P40", "GPU-F", "通用型"),
                ),
            ),
        ),
        "E5-2650v4" => array(
            128 => array(
                14 => array(
                    72600 => array("2*2650v4/128G/12*6T SATA+2*300G SAS/2*1G+2*10G", "大数据-I", "存储型"),
                ),
            ),
            256 => array(
                4 => array(
                    16000 => array("2*2650v4/256G/4*4T SATA/2*1G+2*10G/4*P40", "A13", "计算型"),
                ),
                6 => array(
                    16600 => array("2*2650v4/256G/4*4T NVME SSD+2*300G SAS/2*1G+2*25G", "B15", "存储型"),
                ),
                14 => array(
                    72600 => array(
                        array("2*2650v4/256G/12*6T SATA+2*300G SAS/2*1G+2*10G", "大数据-I(256G)", "存储型"),
                        array("2*2650v4/256G/12*6T SATA+2*300G SAS/2*1G+2*10G", "B14", "存储型")
                    ),
                )
            ),
            64 => array(
                2 => array(
                    600 => array("2*2650v4/64G/2*300G SAS/2*1G+2*10G/2*M40", "A19", "计算型"),
                ),
            )
        ),
        "E5-2667v4" => array(
            256 => array(
                8 => array(
                    6360 => array("2*2667v4/256G/6*960G SSD+2*300G SAS/4*10G", "A110", "通用型"),
                    6240 => array("2*2667v4/256G/6*960G+2*240G SSD/2*10G", "A14", "通用型"),
                ),
            ),
        ),
        "E5-2680v4" => array(
            256 => array(
                6 => array(
                    7000 => array("2*2667v4/256G/6*960G+2*240G SSD/2*10G", "GPU-J", "通用型"),
                ),
                8 => array(
                    7800 => array("2*2680v4/256G/6*1.2T SAS+2*300G SAS+R/2*1G+2*10G/4*P40", "GPU-I","通用型"),
                ),
            ),
        ),
        "E5-2683v4" => array(
            256 => array(
                3 => array(
                    4600 => array("2*2683v4/256G/1*4T NVME+2*300G SAS/2*1G+2*10G","C11","通用型"),
                ),
                4 => array(
                    1200 => array(
                        array("2*2683v4/256G/4*300G SAS/2*1G+4*10G", "E110", "通用型"),
                        array("2*2683v4/256G/4*300G SAS+R/2*1G+2*40G", "E17", "通用型"),
                    ),
                    3200 => array("2*2683v4/256G/4*800G SSD/2*1G+2*10G", "计算-B", "通用型"),
                ),
                6 => array(
                    7000 => array("2*2683v4/256G/4*1.6T SSD+2*300G SAS/2*1G+2*10G/4*P100", "A111", "计算型"),
                    8600 => array("2*2683v4/256G/4*2T SATA+2*300G SAS/2*1G+2*10G/2*P40", "A18", "计算型"),
                    1800 => array("2*2683v4/256G/4*300G SAS+2*300G SAS+R/4*10G", "E16", "通用型"),
                ),
                8 => array(
                    7800 => array(
                        array("2*2683v4/256G/6*1.2T SAS+2*300G SAS+R/2*10G/4*P40","A17", "计算型"),
                        array("2*2683v4/256G/6*1.2T SAS+2*300G SAS+R/2*40G/4*P40", "A11", "计算型"),
                    ),
                    6360 => array("2*2683v4/256G/6*960G SSD+2*300G SAS/2*1G+2*10G/4*P40", "A12", "计算型"),
                    4800 => array("2*2683v4/256G/8*600G SAS+R/2*1G+2*10G", "C14", "通用型"),
                    7680 => array("2*2683v4/256G/8*960GSSD+R/2*1G+2*10G", "E125", "通用型"),
                ),
                9 => array(
                    40600 => array("2*2683v4/256G/6*6T SATA+1*4T NVME+2*300G SAS/2*1G+2*10G", "C12", "通用型"),
                ),
                14 => array(
                    15000 => array("2*2683v4/256G/12*1.2T SAS+2*300G SAS+R/4*10G", "C13", "存储型"),
                ),
                18 => array(
                    15960 => array("2*2683v4/256G/16*960G SSD+2*300G SAS+R/2*1G+2*10G", "C16", "存储型"),
                ),
            ),
            512 => array(
                3 => array(
                    4600 => array("2*2683v4/512G/1*4T NVME+2*300G SAS/2*1G+2*10G", "C18", "内存型"),
                ),
                4 => array(
                    2520 => array("2*2683v4/512G/2*960G SSD+2*300G SAS/2*1G+2*10G", "B110", "存储型"),
                ),
                6 => array(
                    24600 => array("2*2683v4/512G/4*6T+2*300G SAS/2*10G", "A16", "通用型"),
                ),
                8 => array(
                    5400 => array("2*2683v4/512G/6*800G SSD+2*300G SAS/4*10G", "D15/云主机-C", "通用型"),
                    6360 => array("2*2683v4/512G/6*960G SSD+2*300G SAS/4*10G", "C20", "通用型"),
                    4800 => array("2*2683v4/512G/8*600G SAS+R/2*1G+2*10G", "C15", "通用型"),
                ),
            ),
        ),
        "E5-2690v4" => array(
            512 => array(
                8 => array(
                    5400 => array("2*2690v4/512G/6*800G SSD+2*300G SAS/4*10G", "云主机-D", "通用型"),
                ),
            ),
        ),
        "E5-2697Av4" => array(
            512 => array(
                8 => array(
                    6240 => array("2*2697Av4/512G/6*960G+2*240G SSD/2*10G", "A15", "通用型"),
                ),
            ),
        ),
        "E5-2698v4" => array(
            256 => array(
                6 => array(
                    4800 => array("2*2698v4/256G/6*800G SSD/2*1G+2*10G", "计算-C", "通用型"),
                ),
                14 => array(
                    15000 => array("2*2698v4/256G/12*1.2T SSD+2*300G SAS+R/2*1G+2*10G", "数据库-D", "通用型"),
                ),
            ),
            512 => array(
                6 => array(
                    4800 => array("2*2698v4/512G/6*800G SSD/2*1G+2*10G", "计算-C(512GB)", "通用型"),
                ),
            ),
            64 => array(
                8 => array(
                    37600 => array("2*E5-2698v4/64G/2*800G SSD+6*6TB SATA+R/2*1G+4*10G", "E113", "通用型")
                ),
            ),
        ),
    );
    /**
     * 套餐的坐标，用于distance_method来计算距离
     * 结构如下:
     * 套餐名 => array(
     *      'point'     => array( cpu, memory, hard_number, hard_sizes),
     *      'type'      => string,
     *      'config'    => string
     * )
     */
    public static $combo_points = array(
        'N12'       => array(
            'point'     => array('E3-1585v5',32,2,960),
            'type'      => '通用型',
            'config'    => 'E3-1585v5/32G/2*480G SSD/2*10G',
        ),
        '视频转码-A' => array(
            'point'     => array('E3-1585v5',32,2,4000),
            'type'      => '通用型',
            'config'    => 'E3-1585v5/32G/2*2TB SATA/2*10G'
        ),
        'E12'       => array(
            'point'     => array('E5-2620v4',128,4,1200),
            'type'      => '通用型',
            'config'    => '2*2620v4/128G/4*300G SAS+R/2*1G+2*10G'
        ),
        'E19'       => array(
            'point'     => array('E5-2620v4',128,4,1200),
            'type'      => '通用型',
            'config'    => '2*2620v4/128G/4*300G SAS+R/2*1G+2*10G',
        ),
        'E13'       => array(
            'point'     => array('E5-2620v4',128,4,3840),
            'type'      => '通用型',
            'config'    => '2*2620v4/128G/4*960G SSD/2*1G',
        ),
        '云数据库-B' => array(
            'point'     => array('E5-2620v4',128,10,7000),
            'type'      => '通用型',
            'config'    => '2*2620v4/128G/8*800G SSD+2*300G SAS+R/2*10G',
        ),
        'D11'       => array(
            'point'     => array('E5-2620v4',128,10,7000),
            'type'      => '通用型',
            'config'    => '2*2620v4/128G/8*800G SSD+2*300G SAS+R/2*1G+2*10G'
        ),
        'D12'       => array(
            'point'     => array('E5-2620v4',128,10,8280),
            'type'      => '通用型',
            'config'    => '2*2620v4/128G/8*960G SSD+2*300G SAS+R/2*1G+2*10G ',
        ),
        'B17'       => array(
            'point'     => array('E5-2620v4',128,12,19800),
            'type'      => '存储型',
            'config'    => '2*2620v4/128G/2*300G SAS+10*1.92T SSD/4*10G',
        ),
        'B13'       => array(
            'point'     => array('E5-2620v4',128,14,15000),
            'type'      => '存储型',
            'config'    => '2*2620v4/128G/12*1.2T SAS+2*300G SAS+R/2*1G+2*10G',
        ),
        '云存储-A'   => array(
            'point'     => array('E5-2620v4',128,14,72600),
            'type'      => '存储型',
            'config'    => '2*2620v4/128G/12*6T SATA+2*300G SAS/2*10G',
        ),
        'B16'       => array(
            'point'     => array('E5-2620v4',128,14,72600),
            'type'      => '存储型',
            'config'    => '2*2620v4/128G/12*6T SATA+2*300G SAS/4*10G'
        ),
        '云硬盘-C'   => array(
            'point'     => array('E5-2620v4',128,14,19800),
            'type'      => '存储型',
            'config'    => '2*2620v4/128G/2*300G SAS+12*1.6T SSD/4*10G'
        ),
        '云硬盘-D'   => array(
            'point'     => array('E5-2620v4',128,14,48600),
            'type'      => '存储型',
            'config'    => '2*2620v4/128G/2*300G SAS+12*4T SATA/4*10G',
        ),
        'B120'      => array(
            'point'     => array('E5-2620v4',128,22,19800),
            'type'      => '存储型',
            'config'    => '2*2620v4/128G/2*300G SAS+20*960G SSD/4*10G',
        ),
        'B18'       => array(
            'point'     => array('E5-2620v4',128,23,21800),
            'type'      => '存储型',
            'config'    => '2*2620v4/128G/2*300G SAS+20*960G SSD+2T NVMe/4*10G'
        ),
        'M12'       => array(
            'point'     => array('E5-2620v4',256,4,1200),
            'type'      => '内存型',
            'config'    => '2*2620v4/256G/4*300G SAS+R/2*1G+2*10G'
        ),
        '大内存-D'   => array(
            'point'     => array('E5-2620v4',256,4,1200),
            'type'      => '通用型',
            'config'    => '2*2620v4/256G/4*300G SAS+R/2*1G+2*10G'
        ),
        '云缓存-A'   => array(
            'point'     => array('E5-2620v4',256,4,3200),
            'type'      => '通用型',
            'config'    => '2*2620v4/256G/4*800G SSD+R/2*10G'
        ),
        'CDN-A'     => array(
            'point'     => array('E5-2620v4',256,6,3800),
            'type'      => '通用型',
            'config'    => '2*2620v4/256G/4*800G SSD+2*300G SAS/2*10G',
        ),
        'N11'       => array(
            'point'     => array('E5-2620v4',256,6,4440),
            'type'      => '通用型',
            'config'    => '2*2620v4/256G/4*960G SSD+2*300G SAS+R/6*10G'
        ),
        'B19'       => array(
            'point'     => array('E5-2620V4',256,14,72600),
            'type'      => '存储型',
            'config'    => '2*2620v4/256G/12*6T SATA+2*300G SAS/2*1G+2*10G-4PCIE'
        ),
        'D13'       => array(
            'point'     => array('E5-2620v4',256,14,12120),
            'type'      => '存储型',
            'config'    => '2*2620v4/256G/12*960G SSD+2*300G SAS+R/2*1G+2*10G '
        ),
        'E124'      => array(
            'point'     => array('E5-2620v4',256,14,12120),
            'type'      => '存储型',
            'config'    => '2*2620v4/256G/12*960G SSD+2*300G SAS+R/2*1G+2*10G+2*16Gb HBA',
        ),
        'M11'       => array(
            'point'     => array('E5-2620v4', 512,4,1200),
            'type'      => '内存型',
            'config'    => '2*2620v4/512G/4*300G SAS+R/2*1G+2*10G',
        ),
        'E122'      => array(
            'point'     => array('E5-2620v4',512,6,4440),
            'type'      => '内存型',
            'config'    => '2*2620v4/512G/4*960G SSD+2*300G SAS/4*10G',
        ),
        'E123'      => array(
            'point'     => array('E5-2620v4',512,6,4440),
            'type'      => '内存型',
            'config'    => '2*2620v4/512G/4*960G SSD+2*300G SAS/6*10G'
        ),
        'E11'       => array(
            'point'     => array('E5-2620v4',64,4,1200),
            'type'      => '通用型',
            'config'    => '1*2620v4/64G/4*300G SAS+R/2*1G'
        ),
        '仓储应用-A'    => array(
            'point'     => array('E5-2620v4',64,4,1200),
            'type'      => '通用型',
            'config'    => '1*2620v4/64G/4*300G SAS+R/2*1G'
        ),
        '基本-D'      => array(
            'point'     => array('E5-2620v4',64,4,1200),
            'type'      => '通用型',
            'config'    => '2*2620v4/64G/4*300G SAS+R/2*1G+2*10G'
        ),
        'E14'       => array(
            'point'     => array('E5-2620v4',64,4,1200),
            'type'      => '通用型',
            'config'    => '2*2620v4/64G/4*300G SAS+R/2*1G+2*10G'
        ),
        'E115'      => array(
            'point'     => array('E5-2620v4',64,8,37600),
            'type'      => '存储型',
            'config'    => '2*2620v4/64G/2*800G SSD + 6*6TB SATA/2*1G+4*10G'
        ),
        'E18'       => array(
            'point'     => array('E5-2620v4',64,8,4200),
            'type'      => '通用型',
            'config'    => '2*2620v4/64G/6*600GB SAS+2*300G SAS+R/2*1G+2*10G'
        ),
        'E15'       => array(
            'point'     => array('E5-2620v4',64,8,7680),
            'type'      => '存储型',
            'config'    => '2*2620v4/64G/8*960G SSD/2*1G'
        ),
        'B12'       => array(
            'point'     => array('E5-2620v4',64,14,48600),
            'type'      => '存储型',
            'config'    => '2*2620v4/64G/12*4T SATA+2*300G SAS/2*1G+2*10G'
        ),
        '存储-C'      => array(
            'point'     => array('E5-2620v4',64,14,48600),
            'type'      => '存储型',
            'config'    => '2*2620v4/64G/12*4T SATA+2*300G SAS/2*1G+2*10G'
        ),
        'B11'       => array(
            'point'     => array('E5-2620v4',64,18,19800),
            'type'      => '存储型',
            'config'    => '2*2620v4/64G/16*1.2T SAS+2*300G SAS/2*1G+2*10G'
        ),
        '存储-B'  => array(
            'point'     => array('E5-2620v4',64,18,19800),
            'type'      => '存储型',
            'config'    => '2*2620v4/64G/16*1.2T SAS+2*300G SAS/2*1G+2*10G'
        ),
        '仓储数据库-A'       => array(
            'point'     => array('E5-2640v3',128,4,3200),
            'type'      => '通用型',
            'config'    => '2*2640v3/128G/4*800G SSD/2*1G'
        ),
        'E112'      => array(
            'point'     => array('E5-2640v3',128,4,2400),
            'type'      => '通用型',
            'config'    => '2*E5-2640v3/128G/4*600GB 15K SAS+R/4*1G'
        ),
        '数据库-A'     => array(
            'point'     => array('E5-2640v3',128,10,7000),
            'type'      => '通用型',
            'config'    => '2*2640v3/128G/8*800G SSD+2*300G SAS+R/2*1G+2*10G'
        ),
        '大数据-J'     => array(
            'point'     => array('E5-2640v3',256,14,10200),
            'type'      => '通用型',
            'config'    => '2*2640v3/256G/12*800G SSD+2*300G SAS+R/2*1G+2*10G'
        ),
        'E111'      => array(
            'point'     => array('E5-2640v3',64,4,2400),
            'type'      => '通用型',
            'config'    => '2*E5-2640v3/64G/4*600GB 15K SAS+R/4*1G'
        ),
        '仓储数据库-B'       => array(
            'point'     => array('E5-2640v3',64,8,6400),
            'type'      => '通用型',
            'config'    => '2*2640v3/64G/8*800G SSD+R/2*1G'
        ),
        'GPU-G'     => array(
            'point'     => array('E5-2640v4',128,4,16000),
            'type'      => '通用型',
            'config'    => '2*2640v4/128G/4*4T SATA/2*1G+2*10G/4*P4'
        ),
        'E114'      => array(
            'point'     => array('E5-2640v4',128,4,3200),
            'type'      => '通用型',
            'config'    => '2*E5-2640v4/128G/4*800G SSD+R/2*1G+4*10G'
        ),
        'GPU-F'     => array(
            'point'     => array('E5-2640v4',256,4,16000),
            'type'      => '通用型',
            'config'    => '2*2640v4/256G/4*4T SATA/2*1G+2*10G/4*P40'
        ),
        '大数据-I'     => array(
            'point'     => array('E5-2650v4',128,14,72600),
            'type'      => '存储型',
            'config'    => '2*2650v4/128G/12*6T SATA+2*300G SAS/2*1G+2*10G'
        ),
        'A13'       => array(
            'point'     => array('E5-2650v4',256,4,16000),
            'type'      => '计算型',
            'config'    => '2*2650v4/256G/4*4T SATA/2*1G+2*10G/4*P40 '
        ),
        'B15'       => array(
            'point'     => array('E5-2650v4',256,6,16600),
            'type'      => '存储型',
            'config'    => '2*2650v4/256G/4*4T NVME SSD+2*300G SAS/2*1G+2*25G'
        ),
        'B14'       => array(
            'point'     => array('E5-2650v4',256,14,72600),
            'type'      => '存储型',
            'config'    => '2*2650v4/256G/12*6T SATA+2*300G SAS/2*1G+2*10G'
        ),
        '大数据-I(256G)'   => array(
            'point'     => array('E5-2650v4',256,14,72600),
            'type'      => '存储型',
            'config'    => '2*2650v4/256G/12*6T SATA+2*300G SAS/2*1G+2*10G'
        ),
        'A19'       => array(
            'point'     => array('E5-2650v4',64,2,600),
            'type'      => '计算型',
            'config'    => '2*2650v4/64G/2*300G SAS/2*1G+2*10G/2*M40'
        ),
        'A110'      => array(
            'point'     => array('E5-2667v4',256,8,6360),
            'type'      => '通用型',
            'config'    => '2*2667v4/256G/6*960G SSD+2*300G SAS/4*10G'
        ),
        'A14'       => array(
            'point'     => array('E5-2667v4',256,8,6240),
            'type'      => '通用型',
            'config'    => '2*2667v4/256G/6*960G+2*240G SSD/2*10G'
        ),
        'GPU-J'     => array(
            'point'     => array('E5-2680v4',256,6,7000),
            'type'      => '通用型',
            'config'    => '2*2680v4/256G/4*1.6T SSD+2*300G SAS/2*1G+2*10G/4*P40'
        ),
        'GPU-I'     => array(
            'point'     => array('E5-2680v4',256,8,7800),
            'type'      => '通用型',
            'config'    => '2*2680v4/256G/6*1.2T SAS+2*300G SAS+R/2*1G+2*10G/4*P40'
        ),
        'C11'       => array(
            'point'     => array('E5-2683v4',256,3,4600),
            'type'      => '通用型',
            'config'    => '2*2683v4/256G/1*4T NVME+2*300G SAS/2*1G+2*10G'
        ),
        'E110'      => array(
            'point'     => array('E5-2683v4',256,4,1200),
            'type'      => '通用型',
            'config'    => '2*2683v4/256G/4*300G SAS/2*1G+4*10G'
        ),
        'E17'       => array(
            'point'     => array('E5-2683v4',256,4,1200),
            'type'      => '通用型',
            'config'    => '2*2683v4/256G/4*300G SAS+R/2*1G+2*40G'
        ),
        '计算-B'      => array(
            'point'     => array('E5-2683v4',256,4,3200),
            'type'      => '通用型',
            'config'    => '2*2683v4/256G/4*800G SSD/2*1G+2*10G'
        ),
        'A111'      => array(
            'point'     => array('E5-2683v4',256,6,7000),
            'type'      => '计算型',
            'config'    => '2*2683v4/256G/4*1.6T SSD+2*300G SAS/2*1G+2*10G/4*P100'
        ),
        'A18'       => array(
            'point'     => array('E5-2683v4',256,6,8600),
            'type'      => '计算型',
            'config'    => '2*2683v4/256G/4*2T SATA+2*300G SAS/2*1G+2*10G/2*P40'
        ),
        'E16'       => array(
            'point'     => array('E5-2683v4',256,6,1800),
            'type'      => '通用型',
            'config'    => '2*2683v4/256G/4*300G SAS+2*300G SAS+R/4*10G'
        ),
        'A17'       => array(
            'point'     => array('E5-2683v4',256,8,7800),
            'type'      => '计算型',
            'config'    => '2*2683v4/256G/6*1.2T SAS+2*300G SAS+R/2*10G/4*P40'
        ),
        'A11'       => array(
            'point'     => array('E5-2683v4',256,8,7800),
            'type'      => '计算型',
            'config'    => '2*2683v4/256G/6*1.2T SAS+2*300G SAS+R/2*40G/4*P40'
        ),
        'A12'       => array(
            'point'     => array('E5-2683v4',256,8,6360),
            'type'      => '计算型',
            'config'    => '2*2683v4/256G/6*960G SSD+2*300G SAS/2*1G+2*10G/4*P40'
        ),
        'C14'       => array(
            'point'     => array('E5-2683v4',256,8,4800),
            'type'      => '通用型',
            'config'    => '2*2683v4/256G/8*600G SAS+R/2*1G+2*10G'
        ),
        'E125'      => array(
            'point'     => array('E5-2683v4',256,8,7680),
            'type'      => '通用型',
            'config'    => '2*2683v4/256G/8*960GSSD+R/2*1G+2*10G'
        ),
        'C12'       => array(
            'point'     => array('E5-2683v4',256,9,40600),
            'type'      => '通用型',
            'config'    => '2*2683v4/256G/6*6T SATA+1*4T NVME+2*300G SAS/2*1G+2*10G'
        ),
        'C13'       => array(
            'point'     => array('E5-2683v4',256,14,15000),
            'type'      => '存储型',
            'config'    => '2*2683v4/256G/12*1.2T SAS+2*300G SAS+R/4*10G'
        ),
        'C16'       => array(
            'point'     => array('E5-2683v4',256,18,15960),
            'type'      => '存储型',
            'config'    => '2*2683v4/256G/16*960G SSD+2*300G SAS+R/2*1G+2*10G'
        ),
        'C18'       => array(
            'point'     => array('E5-2683v4',512,3,4600),
            'type'      => '内存型',
            'config'    => '2*2683v4/512G/1*4T NVME+2*300G SAS/2*1G+2*10G'
        ),
        'B110'      => array(
            'point'     => array('E5-2683v4',512,4,2520),
            'type'      => '内存型',
            'config'    => '2*2683v4/512G/2*960G SSD+2*300G SAS/2*1G+2*10G'
        ),
        'A16'       => array(
            'point'     => array('E5-2683v4',512,6,24600),
            'type'      => '通用型',
            'config'    => '2*2683v4/512G/4*6T+2*300G SAS/2*10G'
        ),
        'D15'       => array(
            'point'     => array('E5-2683v4',512,8,5400),
            'type'      => '通用型',
            'config'    => '2*2683v4/512G/6*800G SSD+2*300G SAS/4*10G'
        ),
        '云主机-C'     => array(
            'point'     => array('E5-2683v4',512,8,5400),
            'type'      => '通用型',
            'config'    => '2*2683v4/512G/6*800G SSD+2*300G SAS/4*10G'
        ),
        'C20'       => array(
            'point'     => array('E5-2683v4',512,8,6360),
            'type'      => '通用型',
            'config'    => '2*2683v4/512G/6*960G SSD+2*300G SAS/4*10G'
        ),
        'C15'       => array(
            'point'     => array('E5-2683v4',512,8,4800),
            'type'      => '通用型',
            'config'    => '2*2683v4/512G/8*600G SAS+R/2*1G+2*10G'
        ),
        '云主机-D'     => array(
            'point'     => array('E5-2690v4',512,8,5400),
            'type'      => '通用型',
            'config'    => '2*2690v4/512G/6*800G SSD+2*300G SAS/4*10G'
        ),
        'A15'       => array(
            'point'     => array('E5-2697Av4',512,8,6240),
            'type'      => '通用型',
            'config'    => '2*2697Av4/512G/6*960G+2*240G SSD/2*10G'
        ),
        '计算-C'      => array(
            'point'     => array('E5-2698v4',256,6,4800),
            'type'      => '通用型',
            'config'    => '2*2698v4/256G/6*800G SSD/2*1G+2*10G'
        ),
        '数据库-D'     => array(
            'point'     => array('E5-2698v4',256,14,15000),
            'type'      => '通用型',
            'config'    => '2*2698v4/256G/12*1.2T SSD+2*300G SAS+R/2*1G+2*10G'
        ),
        '计算-C(512GB)'   => array(
            'point'     => array('E5-2698v4',512,6,4800),
            'type'      => '通用型',
            'config'    => '2*2698v4/512G/6*800G SSD/2*1G+2*10G'
        ),
        'E113'      => array(
            'point'     => array('E5-2698v4',64,8,37600),
            'type'      => '通用型',
            'config'    => '2*E5-2698v4/64G/2*800G SSD+6*6TB SATA+R/2*1G+4*10G'
        ),
    );

    /**
     * @return mixed
     */
    public function cpu_trim(){
        /**
         * 解析Physical_Cpu_Model字段，返回套餐-类型字典中的键值
         * 通过观察数据中的数据，判断如下trim规则
         * 0：如果字段为空，返回CPUException异常
         * 1：以，或者空格分割字段，判断出有几个CPU
         * 2：对每个CPU有
         *      a: intel - CPUXXXX@ XXXX为trim结果(统一格式为EX-XXXXX)
         *      b: AMD   - processorXXXX为trim结果
         * 3: 如果trim型号相同，返回一个即可，如果不同，按照字典序顺序，以，分割串行输出
         */
        if (isset($this->_trim_cpu)) {
            return $this->_trim_cpu;
        }
        $cpu = $this->getAttr("Physical_Cpu_Model");
        if (!$cpu) {
            throw new CPUException("Physical_Cpu_Model字段为空，需要运维同学处理");
        }
        $cpu_arr = preg_split("/[,\s]/",$cpu,-1,PREG_SPLIT_NO_EMPTY);
        $cpu_str_arr = array();
        foreach ($cpu_arr as $c) {
            // 判断cpu类型
            if (strpos($c,'Intel')) {
                $trim_c0 = strstr($c,"CPU");
                $trim_c = substr($trim_c0,3,strpos($trim_c0,"@")-3);
                // 如果没有-添加
                if (strpos($trim_c,"-")) {
                    ;
                } else {
                    $trim_c = substr_replace($trim_c,'-',2,0);
                }
            } else {
                $trim_c = substr(strstr($c,"Processor"),strlen("Processor"));
            }
            if (in_array($trim_c, $cpu_str_arr)) {
                ;
            } else {
                if ($trim_c) {
                    $cpu_str_arr[] = $trim_c;
                }
            }
        }
        // 组合键值结果，按照字典序排列，用逗号串行
        sort($cpu_str_arr);
        $this->_trim_cpu = join(",",$cpu_str_arr);
        return $this->_trim_cpu;
    }

    public function memory_trim(){
        /**
         * 处理 Physical_Memory_Sizes 字段，返回int的内存
         * 1: 如果不是\d+GB格式，报出MemeoryException
         * 2: 返回int(\d+)
         */
        if (isset($this->_trim_memory)) {
            return $this->_trim_memory;
        }
        $memory = $this->getAttr("Physical_Memory_Sizes");
        if (! preg_match('/(\d+GB)$/',$memory,$matches)) {
            throw new MEMException("内存存储方式不是\d+GB，需要运维人员确认格式:".$memory);
        } else {
            $memory0 = (int)$matches[0];
            $memory0 = decbin($memory0);
            if (! preg_match('/^10+$/',$memory0)) {
                $memory0 = "1" . str_replace("1", "0", $memory0);
            }
            $this->_trim_memory = bindec($memory0);
        }
        return $this->_trim_memory;
    }

    public function hard_number_trim() {
        if (isset($this->_hard_number)) {return $this->_hard_number;}
        $hard_number = $this->getAttr('Physical_Hard_Number');
        if (!preg_match('/(\d+)/',$hard_number, $matches)){
            throw new \Exception('硬盘总数不存在');
        } else {
            $this->_hard_number = (int)$matches[0];
        }
        return $this->_hard_number;
    }

    public function dict_has_cpu_and_memory()
    {
        /**
         * 检查结果查询结果是否在套餐-类型字典中
         * 是： true
         * 否： false
         * 检查逻辑如下：
         *  1：看combo_type_hash字典中是否有cpu_trim后的的键值，没有返回false
         *  2：看combo_type_hash二级键中是否有Physical_Memory_Sizes字段的结果，没有返回false
         *  3：返回true
         */
        $cpu_key = $this->cpu_trim();
        $memory_key = $this->memory_trim();
        //echo $cup_key, " ===> ", $memory_key, "<br>";
        //echo array_key_exists($cup_key, self::$combo_type_hash);
        if (array_key_exists($cpu_key, self::$combo_type_hash)) {
            if (array_key_exists($memory_key,self::$combo_type_hash[$cpu_key])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function dict_has_cpu() {
        $cpu_key = $this->cpu_trim();
        return array_key_exists($cpu_key,self::$combo_type_hash) ? true : false;
    }

    public function dict_has_memory() {
        $cpu_key = $this->cpu_trim();
        $memory_key = $this->memory_trim();
        return $this->dict_has_cpu()
            ? array_key_exists($memory_key,self::$combo_type_hash[$cpu_key])
                ? true
                : false
            : false;
    }

    public function total_hard_sizes()
    {
        /**
         * 通过解析 Physical_Hard_size，Physical_Hard_Number 字段，计算磁盘的总空间
         * 计算方式有如下可能：
         * 1： Physical_Hard_size只有一个值 -- Physical_Hard_size*Physical_Hard_Number
         * 2： Physical_Hard_size有很多值 -- 解析Physical_Hard_size字段，返回数组，然后把数组相加即可
         * 返回硬盘总空间，以GB为单位
         */
        if (isset($this->_total_hard)) {return $this->_total_hard;}
        $total_hard_str = $this->getAttr("Physical_Hard_size");
        $hard_arr = preg_split("/GB|\s|MB|TB/", $total_hard_str, -1, PREG_SPLIT_NO_EMPTY);
        //return $hard_arr;
        $total_hard = 0;
        if (count($hard_arr) == 1) {
            $hard_number = $this->getAttr("Physical_Hard_Number");
            $total_hard += $this->hard_normal((float)$hard_arr[0])*$hard_number;
            $this->_total_hard = $total_hard;
        } else {
            foreach ($hard_arr as $hard_item) {
                $total_hard += $this->hard_normal((float)$hard_item);
            }
            $this->_total_hard = $total_hard;
        }
        return $this->_total_hard;
    }

    public function hard_normal($hard)
    {
        /**
         * 标准化数据库中硬盘空间，由于数据库中的Physical_Hard_size字段内容不一致，需要标准化，按照GB返回。
         * 同时统一硬盘量级，例如279.396GB转化为300GB
         * 具体方案暂定：ceil(round(size/0.93)/100)*100
         * 如果hard参数异常例如为0，返回HardException异常
         * 实际计算中用1024，键值用了1000作为转换单位
         */
        // 检查输入参数
        if ($hard === 0) {
            throw new \Exception("硬盘输入为0，请检查！");
        }
        if ($hard == 0) {
            return 0;
        }
        if ($hard > 5000) {
            // MB 级别
            $hard = $hard/1024;
        } elseif ($hard < 6) {
            // TB 级别
            $hard = $hard * 1024;
        } else {
            if (is_int($hard)) {
                return (int)$hard;
            }
        }
        $hard = floor($hard);
        if ($hard %1024 == 0) {
            return (int)$hard/1024*1000;
        }
        if ($hard %1000 == 0) {
            return (int)$hard;
        }
        $ret = 0;
        $params = array(0.93);
        foreach ( $params as $param) {
            $ret1 = round(round($hard/$param)/100)*100;
            if ($ret1 < $hard) {
                $ret1 = round(round($hard/$param)/10) * 10;
            }
            $ret += $ret1;
            //echo "fun: ", $ret1, "<br>";
        }
        $ret = $ret/count($params);
        //echo ceil(round($hard/0.93)/100)*100,"<br>";
        return (int)$ret;
    }

    public function match($type=1, $method='tree_method')
    {
        /**
         * 匹配选择函数，可以匹配的方法有:
         * tree_method: 即第一次做的，用$combo_type_hash来暴力分类的方法。
         *       会有模糊匹配，但是对于cpu无法匹配的情况，处理不了
         * distance_method: 用记录到套餐的距离做为分类方式。
         */
        try {
            return $this->$method($type);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function distance_method($type=1, $debug=true) {
        /**
         * type = 1: 报类型
         * type = 2: 报类型，套餐
         * type = 3: 报类型，套餐，配置
         * debug = true: 报准确率
         * debug = false： 不报准确率
         */
        $cpu = $this->cpu_trim();
        $memory = $this->memory_trim();
        //$hard_number = $this->getAttr('Physical_Hard_Number');
        $hard_number = $this->hard_number_trim();
        $hard_size = $this->total_hard_sizes();
        //echo "$cpu -> $memory -> $hard_number -> $hard_size<br>";
        /**
         * 检查$combo_points
         *
        foreach (self::$combo_points as $key => $point) {
            echo $key,"<br>";
            var_dump($point['point']);
        }
         */
        $min_dist = 4;
        $points = [];
        foreach (self::$combo_points as $key => $point) {
            $dist = $this->cal_distance(array($cpu, $memory, $hard_number, $hard_size), $point['point']);
            if ($dist < $min_dist) {
                $min_dist = $dist;
                $points = [$key];
            } elseif ($dist == $min_dist) {
                $points[] = $key;
            }
        }
        $percentage = $debug ? round((3 - $min_dist)/3*100,3): '';
        $result = [];
        foreach ($points as $combo) {
            $data = self::$combo_points[$combo];
            for ($i=0; $i<$type;$i++) {
                switch ($i) {
                    case 0:
                        $result['type'][] = $type == 1 ? $data['type'] . "($percentage)" : $data['type'];
                        break;
                    case 1:
                        $result['combo'][] = $combo."($percentage)";
                        break;
                    case 2:
                        $result['config'][] = $data['config'];
                        break;
                }
            }
        }
        array_walk($result,function (&$item){$item = array_unique($item);});
        //throw new \Exception('正在开发中~~~');
        return $result;
    }

    public function cal_distance(array $p1, array $p2) {
        //var_dump($p1);
        //var_dump($p2);
        /**
         * 如果型号一致，只是版本不同，给一个0.5否则给1
         */
        if ($p1[0] == $p2[0]) {
            $dim1 = 0;
        } else{
           $cpu1 = preg_replace('/v\d/','',$p1[0]);
           $cpu2 = preg_replace('/v\d/','',$p2[0]);
           if ($cpu1 == $cpu2) {
               $dim1 = 0.5;
           } else {
               $dim1 = 1;
           }
        }
        $dim2 = $p1[1] == $p2[1] ? 0 : 1;
        $sum = $dim1 + $dim2;
        if ($sum > 1.5) {return $sum;}
        $x1 = $p1[2]*1000; $x2 = $p2[2]*1000;
        $y1 = $p1[3]; $y2 = $p2[3];
        $dot = pow($x1*$x2+$y1*$y2,2);
        $mode1 = pow($x1,2) + pow($y1,2);
        $mode2 = pow($x2,2) + pow($y2,2);
        $dim3 = sqrt(1-$dot/($mode1*$mode2));
        //$dim3 = round(sin(acos($dot/($mode1*$mode2))),3);
        //$dim3 = $dim3 < 1e-4 ? 0 : $dim3;
        //echo "$dim3<br>";
        return $sum + $dim3;
    }

    public function tree_method($type=1) {
        /**
         * 数方法匹配主函数，用于确认实例属于哪个套餐-类型：
         * 有匹配结果，返回一个字符串，按照$type返回不同结果
         * 如果实例不符合匹配要求，返回各类异常
         * $type = 1: 返回array(类型)
         * $type = 2: 返回array(类型,套餐)
         * $type = 3: 返回array(类型\t套餐\t配置)
         *
         * 如果选择了$type = 2,3则只进行精确匹配，不进行模糊匹配
         */
        try{
            //进行精确匹配，如果出错，按照不同结果，处理之
            return $this->tree_match_exact($type);
        } catch (CPUException $e) {
            throw new CPUException($e->getMessage());
        } catch (MEMException $e) {
            if ($type > 1){
                throw new MEMException($e->getMessage());
            } else {
                return $this->tree_match_with_vote(1);
            }
        } catch (HardNumberException $e) {
            if ($type > 1) {
                throw new HardNumberException($e->getMessage());
            } else {
                return $this->tree_match_with_vote(2);
            }
        } catch (HardSizesException $e) {
            if ($type > 1) {
                throw new HardSizesException($e->getMessage());
            } else {
                return $this->tree_match_with_vote(3);
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function tree_match_exact($type=1) {
        /**
         * 精确匹配套餐树，按照$type的类型返回结果
         */
        $key0 = $this->cpu_trim();
        $key1 = $this->memory_trim();
        if (!$this->dict_has_cpu()){throw new CPUException("CPU型号字典中没有:".$key0);}
        if (!$this->dict_has_memory()){throw new MEMException("内存型号字典中没有:".$key0."-".$key1);}
        $key2 = $this->getAttr("Physical_Hard_Number");
        $combo_hash = self::$combo_type_hash[$key0][$key1];
        if (array_key_exists($key2, $combo_hash)) {
            $combo_hash = $combo_hash[$key2];
            $key3 = $this->total_hard_sizes();
            if (array_key_exists($key3,$combo_hash)) {
                return $this->tree_trim_result($combo_hash[$key3],$type);
            } else {
                throw new HardSizesException(
                    "没有响应的磁盘总空间，需要确认数据库或更新字典:".
                    $key0."-".$key1."-".$key2."-".$key3
                );
            }
        } else {
            throw new HardNumberException(
                "硬盘总数不对，需要确认数据库信息，或者更新字典:" .
                $key0."-".$key1."-". $key2
            );
        }
    }

    public function tree_trim_result(&$str_array, $type=1) {
        if (! in_array($type, array(1,2,3))) {
            throw new \Exception("\$type只能为1,2,3!");
        }
        $ret = array();
        $name2idx = array('type','combo','config');
        for($i=0;$i<$type;$i++) {
            is_array($str_array[0])
                ?   array_walk($str_array, function($item) use (&$ret, $i, $name2idx){
                        $ret[$name2idx[$i]][] = $item[2 - $i];
                    })
                :   $ret[$name2idx[$i]][] = $str_array[2 - $i];
        }
        array_walk($ret,function (&$item){$item = array_unique($item);});
        return $ret;
    }

    public function tree_match_with_vote($level, $debug=true, $break=0.4)
    {
        /**
         * 模糊匹配套餐树，按照投票原则(在已确定的分支下，选择最优可能的结果)
         * 方式为: 计算所有叶节点中，可能的类型，占比最多的为结果
         * 模糊匹配目前只能匹配类型，不能输出配置和套餐
         * $level表示不能解析的层
         * 1 ===> cpu层
         * 2 ===> 硬盘数层
         * 3 ===> 硬板空间层
         */
        $key0 = $this->cpu_trim();
        $key1 = $this->memory_trim();
        $key2 = $this->getAttr("Physical_Hard_Number");
        if ($level == 1) {
            $hash_need = self::$combo_type_hash[$key0];
        } elseif ($level == 2) {
            $hash_need = self::$combo_type_hash[$key0][$key1];
        } elseif ($level == 3) {
            $hash_need = self::$combo_type_hash[$key0][$key1][$key2];
        } else {
            throw new \Exception("模糊匹配层级出错: level = $level");
        }
        /**
         * 记录每种类型的个数
         */
        $ret = array();
        $method = function($hash,$fun) use (&$ret) {
            array_walk($hash, function($item, $idx) use (&$ret, $fun){
                is_array($item)
                    ? $fun($item, $fun)
                    : $idx == 2
                        ? array_key_exists($item,$ret) ? $ret[$item]++ : $ret[$item] = 1
                        :1;
            });
        };
        $method($hash_need,$method);
        arsort($ret);
        $sum = array_sum($ret);
        array_walk($ret, function(&$item,$key) use ($sum){
            $item = round($item/$sum,3);
        });
        $ret_f = array_filter($ret, function(&$item)use($break){
            return $item > $break ? true : false;
        });
        if ($debug) {
            $ret = [];
            array_walk($ret_f, function($item, $key) use (&$ret){
                $ret[] = $key."($item)";
            });
        } else {
            $ret = array_keys($ret_f);
        }
        return array($ret);
        //return array(join("/",array_keys($ret_f)),join("/",$ret_f));
    }

    public function match_pipeline($ret_type=1,$type = "text", $method="tree_method") {
        /**
         * 匹配主函数
         * ret_type: 返回的结果分类
         * type: 返回的类型,有text,json2种情况
         * method: 分类的方法，目前有tree_method, distance_method
         */
        $err = NULL;
        try {
            $res = $this->match($ret_type, $method);
        } catch (\Exception $e) {
            $err = $e->getMessage();
        } catch (CPUException $e) {
            $err = $e->getMessage();
        } catch (MEMException $e) {
            $err = $e->getMessage();
        }
        if ($type == "text") {
            if (isset($err)) {return $err;}
            $ret_str_arr = array();
            foreach ($res as $item) {
                $ret_str_arr[] = join(";", $item);
            }
            return join("\t",$ret_str_arr);
        } elseif ($type == "json") {
            if (isset($err)) {return json_encode(array("error" => $err));}
            return json_encode($res);
        } else {
            throw new Exception("目前只支持text, json两种格式");
        }
    }

}