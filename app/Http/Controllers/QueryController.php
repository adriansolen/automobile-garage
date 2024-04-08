<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueryController extends Controller
{
    public function salesTrends()
    {
        $results1 = DB::select("SELECT 
        YEAR(sales.sale_date) AS year,
        MONTH(sales.sale_date) AS month,
        WEEK(sales.sale_date) AS week,
        brands.brand_name,
        customers.gender,
        CASE 
            WHEN customers.annual_income < 50000 THEN 'Low Income'
            WHEN customers.annual_income BETWEEN 50000 AND 100000 THEN 'Medium Income'
            ELSE 'High Income'
        END AS income_range,
        COUNT(*) AS sales_count
        FROM sales
        JOIN customers ON sales.customer_id = customers.customer_id
        JOIN vehicles ON sales.VIN = vehicles.VIN
        JOIN brands ON vehicles.brand_id = brands.brand_id
        WHERE sale_date >= DATE_SUB(CURDATE(), INTERVAL 3 YEAR)
        GROUP BY year, month, week, brand_name, gender, income_range
        ORDER BY year, month, week, brand_name, gender, income_range");


        $results3 = DB::select("SELECT brands.brand_name, SUM(sales.income) AS total_income
        FROM brands
        JOIN vehicles ON brands.brand_id = vehicles.brand_id
        JOIN sales ON vehicles.VIN = sales.VIN
        WHERE sales.sale_date >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
        GROUP BY brands.brand_name
        ORDER BY total_income DESC
        LIMIT 2");

        $results4 = DB::select("SELECT brands.brand_name, COUNT(*) AS total_sales
        FROM brands
        JOIN vehicles ON brands.brand_id = vehicles.brand_id
        JOIN sales ON vehicles.VIN = sales.VIN
        WHERE sales.sale_date >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
        GROUP BY brands.brand_name
        ORDER BY total_sales DESC
        LIMIT 2;");


        $results6 = DB::select("SELECT 
        dealers.dealer_name as Dealer,
        AVG(DATEDIFF(CURDATE(), inventory.created_at)) AS average_days_in_inventory
        FROM dealers
        JOIN inventory ON dealers.dealer_id = inventory.dealer_id
        GROUP BY dealers.dealer_name
        ORDER BY average_days_in_inventory DESC");

        return response()->json([$results1, $results3, $results4, $results6]);
    }
}
