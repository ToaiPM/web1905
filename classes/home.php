<?php
    class home{
        public function getDSData($timkiem, $Start=null, $Limit=null){
            $sql = "SELECT
                dt.product_id,
                dt.product_title,
                dt.product_price,
                dt.product_discount,
                dt.product_thumbnail,
                hsx.category_name
            FROM
                product dt
            LEFT JOIN category hsx ON dt.category_id = hsx.category_id 
            WHERE dt.product_title LIKE '%$timkiem%' OR hsx.category_name LIKE '%$timkiem%'";
                $sql .= "ORDER BY dt.product_view DESC ";
                $sql .= " LIMIT " . $Start . ", " . $Limit;
                
            $service = new dataservice();
            return $service->ExecuteQuery($sql);
        }

        public function countTotal($timkiem){
            $sql = "SELECT
                    count(dt.product_id) tongsodong
                FROM
                    product dt
                LEFT JOIN category hsx ON dt.category_id = hsx.category_id 
                WHERE dt.product_title LIKE '%$timkiem%' OR hsx.category_name LIKE '%$timkiem%'";
                $service = new dataservice();
                $rs = $service->ExecuteQuery($sql);
                return isset($rs) ? $rs[0]['tongsodong'] : 0;
        }

        public function XemChiTiet($id){
            $sql = "SELECT
                dt.dien_thoai_id,
                dt.dien_thoai_ten,
                dt.dien_thoai_gia_ban,
                dt.dien_thoai_hinh_anh,
                hsx.hang_san_xuat_ten,
                dt.dien_thoai_cpu,
                dt.dien_thoai_ram,
                dt.dien_thoai_man_hinh,
                dt.dien_thoai_pin,
                dt.dien_thoai_tinh_trang 
            FROM
                dien_thoai dt
            LEFT JOIN hang_san_xuat hsx ON dt.hang_san_xuat_id = hsx.hang_san_xuat_id 
            WHERE dt.dien_thoai_id=$id";
            $service = new dataservice();
            $rs = $service->ExecuteQuery($sql);
            return isset($rs) ? $rs[0] : '';
        }
    }
?>