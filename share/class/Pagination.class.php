<?php

/**
 * 分页类
 * 
 * @author      熊飞龙
 * @date        2015-08-27
 * @copyright   Copyright(c) 2015
 * @version     $Id:$
 */
class Pagination
{
    private $_pageSize   = 10;       // 每页显示条数
    private $_totalRows  = 0;        // 数据总条数
    private $_totalPage  = 0;        // 总页数
    private $_pageNo     = 0;        // 当前页码
    private $_pageCenter = 2;        // 左右页码
    private $_pageField  = 'page';   // 分页使用的参数名
    private $_config     = array();  // 分页类配置

    public function __construct(array $config = array())
    {
        $this->_config     = $config;
        $this->_pageField  = isset($config['pageField'])  ? $config['pageField']  : $this->_pageField;
        $this->_pageCenter = isset($config['pageCenter']) ? $config['pageCenter'] : $this->_pageCenter;
        $this->_pageSize   = isset($config['pageSize'])   ? $config['pageSize']   : $this->_pageSize;
    }

    /**
     * 初始化分页类
     * 
     * @param  array  $params
     * 
     * @return void
     */
    private function _init (array $params = array())
    {
        // 数据总页数
        $this->_totalPage = ceil($this->_totalRows / $this->_pageSize);
        $this->_pageNo    = !isset($_REQUEST[ $this->_pageField ]) ? 1 : intval($_REQUEST[ $this->_pageField ]);
        $this->_pageNo    = ($this->_pageNo > $this->_totalPage) ? $this->_totalPage : ($this->_pageNo < 1 ? 1 : $this->_pageNo);
    }

    /**
     * 显示分页数据
     * 
     * @param  int  $total       数据总条数
     * @param  int  $pageSize    每页显示数据条数
     * @param  int  $showStyle   使用的分页样式
     * 
     * @return string
     */
    public function show ($total = 0, $pageSize = 10, $showStyle = 1)
    {
        $this->_totalRows = $total;
        $this->_pageSize  = $pageSize;

        $this->_init();

        $styleFunction = '_show' . $showStyle;

        // 分页样式不存在！
        if (!method_exists($this, $styleFunction)) {

            $htmls = '';
            $htmls .= '<div class="pageShow">';
                $htmls .= '<div class="error">';
                    $htmls .= '<span>' . $styleFunction . ' 指定的分页样式不存在！</span>';
                $htmls .= '</div>';
            $htmls .= '</div>';

            return $htmls;
        }

        return $this->$styleFunction();
    }

    /**
     * 页码显示控制
     */
    private function _pageCode()
    {
        $htmls  = $this->_css();
        $htmls .= $this->_javascript();

        if ($this->_totalRows == 0) {
            return $htmls;
        }

        // 总共显示的页码数
        $showCode = $this->_pageCenter * 2;

        $htmls .= '<form onsubmit="return page()">';
        $htmls .= '<a href="javascript:void(0);" onclick="page(1)">首页</a>';

        if ($this->_pageNo > 1) {
            $htmls .= '<a href="javascript:void(0);" onclick="page(' . ($this->_pageNo - 1) . ')">上一页</a>';    
        }

        $startCode = 1;
        $endCode   = $this->_totalPage;

        if ($this->_totalPage <= $showCode || ($this->_pageNo - $this->_pageCenter) <= 0) {
            $startCode = 1;
            $endCode   = $showCode + 1;
        } else if (($this->_pageNo + $this->_pageCenter) > $this->_totalPage) {
            $startCode = $this->_totalPage - $showCode;
            $endCode   = $this->_totalPage;
        } else {
            $startCode = $this->_pageNo - $this->_pageCenter;
            $endCode   = $startCode + $showCode;
        }

        $endCode = ($endCode > $this->_totalPage) ? $this->_totalPage : $endCode;

        // 拼接页码
        for ($i = $startCode; $i <= $endCode; $i++) {
            if ($i == $this->_pageNo) {
                $htmls .= '<a href="javascript:void(0);" class="select-code" onclick="page(' . $i . ')">' . $i . '</a>';

            } else {
                $htmls .= '<a href="javascript:void(0);" onclick="page(' . $i . ')">' . $i . '</a>';
            }
        }

        if ($this->_pageNo < $this->_totalPage) {
            $htmls .= '<a href="javascript:void(0);" onclick="page(' . ($this->_pageNo + 1) . ')">下一页</a>';
        }

        $htmls .= '<a href="javascript:void(0);" onclick="page(' . $this->_totalPage . ')">尾页</a>';

        $htmls .= '<input type="text" name="" class="page-no" value="' . $this->_pageNo . '" > / ' . $this->_totalPage . ' 页';
        $htmls .= '</form>';

        return $htmls;
    }

    /**
     * 分页页码栏显示样式1
     * 
     * @return string
     */
    private function _show1 ()
    {
        $htmls = '';

        $htmls .= '<div class="pageShow">';
            $htmls .= '<div class="show1">';
                $htmls .= '共 ' . $this->_totalRows . ' 条记录，每页 ' . $this->_pageSize . ' 条';
                $htmls .= $this->_pageCode();
            $htmls .= '</div>';
        $htmls .= '</div>';

        return $htmls;
    }

    /**
     * 样式
     * @return [type] [description]
     */
    private function _css ()
    {
$css = <<<EOT

<style type="text/css">
.pageShow {float: right; height: 42px; line-height: 42px; color: #555555;}
.pageShow a {color: #336699; height: 25px; line-height: 25px; padding: 0 10px; display: inline-block; border: 1px solid #C2D5E3; margin-right: 6px; text-decoration: none;}
.pageShow a:hover {border: 1px solid #336699; }
.pageShow input.page-no {width: 35px; height: 22px; line-height: 22px; text-align: center; padding: 0; margin: 0; }
.pageShow a.select-code {color: #333333; font-weight: bold; border: 1px solid #336699; background: #E5EDF2; } 
.pageShow form {display: inline-block; }
</style>

EOT;

        return $css;
    }

    /**
     * 使用 javascript 处理页码问题
     */
    private function _javascript ()
    {

$script = <<<EOT

<script type="text/javascript">

    function page (pageNo)
    {
        var pageField = "{$this->_pageField}";
        var url = location.href;
        var reg = eval("/([\?|&]" + pageField + "=[0-9a-z]*)/gi");

        var pageFields = url.match(reg);
        var pageNo = (!pageNo) ? $(".page-no").val() : pageNo;

        if (typeof pageFields == 'object' && pageFields) {

            var tempFields = pageFields[0].split("=");
            location.href =  url.replace(reg, tempFields[0] + '=' + pageNo);

        } else {
            if (url.indexOf('?') == '-1' ) {
                location.href = url + '?' + pageField + '=' + pageNo;
            } else {
                location.href = url + '&' + pageField + '=' + pageNo;
            }
        }

        return false;
    }

</script>

EOT;

        return $script;
    }
}

/**
 * 使用示例
 *
 * $page = new Pagination();
 * $page->show('数据总条数', '每页显示条数 默认10条');
 */