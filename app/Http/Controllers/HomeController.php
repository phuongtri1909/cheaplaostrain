<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Comment;
use App\Models\BannerHome;
use App\Models\SmtpSetting;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use App\Models\MortgageMilestone;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class HomeController extends Controller
{
    public function mortgageCalculators($page = 'index')
    {
        $validCalculators = [
            'buying-a-house' => '',
            'refinance-current-loan' => 'refi',
            'maximum-house-i-can-afford' => 'prequal',
            'pay-extra-to-save-more' => 'payoff',
            'principal-reduction' => 'principal',
            'how-much-income-to-buy-a-house' => 'income'
        ];

        $valuesTitlePage = [
            'buying-a-house' => __('Loan Scenario'),
            'refinance-current-loan' => __('Loan Scenario'),
            'maximum-house-i-can-afford' => __('Scenario Builder'),
            'pay-extra-to-save-more' => __('How long until I paid off if I pay extra every month ?'),
            'principal-reduction' => __('Principal Balance Be After x Months'),
            'how-much-income-to-buy-a-house' => __('How much Income to buy a house?'),
        ];

        if (array_key_exists($page, $validCalculators)) {
            $pageType = $validCalculators[$page];
            $title = $valuesTitlePage[$page] ?? '';

            // Đọc dữ liệu JSON từ file riêng cho mỗi pageType
            $calculatorData = $this->getCalculatorDefaults($pageType);

            return view('pages.mortgage-calculators.item-calculator', [
                'page' => $pageType,
                'title' => ucfirst(str_replace('-', ' ', $page)) . ' Calculator',
                'calculator_type' => $page,
                'calculatorDefaults' => $calculatorData,
                'titlePage' => $title,
            ]);
        }

        return view('pages.mortgage-calculators.index');
    }

    private function getCalculatorDefaults($pageType)
    {
        // Đường dẫn tới thư mục chứa các file JSON calculator
        $baseDir = public_path('assets/calculators');

        // Map pageType tới tên file tương ứng
        $fileMapping = [
            '' => 'mortgage.json',
            'refi' => 'refinance.json',
            'prequal' => 'affordability.json',
            'income' => 'income-qualification.json',
            'payoff' => 'extra-payment.json',
            'principal' => 'principal.json'
        ];

        // Lấy tên file dựa vào pageType
        $fileName = $fileMapping[$pageType] ?? 'default.json';
        $filePath = $baseDir . '/' . $fileName;

        // Kiểm tra file tồn tại
        if (File::exists($filePath)) {
            $jsonData = File::get($filePath);
            return $jsonData;
        }

        // Nếu không có file riêng, thử dùng file mặc định
        $defaultFilePath = $baseDir . '/default.json';
        if (File::exists($defaultFilePath)) {
            return File::get($defaultFilePath);
        }

        // Fallback: Trả về mảng trống nếu không tìm thấy file
        return '[]';
    }

    public function appCalculator()
    {
        return view('pages.app-calculator');
    }


    public function index()
    {
        $banners = BannerHome::orderBy('order', 'asc')->get();


        return view('pages.home', compact('banners'));
    }

    public function EmailYouACopy(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'options' => 'required|array',
            'result' => 'required|array',
            'email' => 'required|email'
        ]);

        // Extract data
        $options = $request->options;
        $result = $request->result;
        $userEmail = $request->email;

        // Create new Excel file
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set up headers with styling
        $sheet->setCellValue('A1', 'Mortgage Calculation Details');
        $sheet->mergeCells('A1:D1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);

        // Basic Loan Information
        $sheet->setCellValue('A3', 'Loan Program');
        $sheet->setCellValue('B3', ucfirst($options['type']));

        $sheet->setCellValue('A4', 'Property Price');
        $sheet->setCellValue('B4', '$' . number_format($options['property_price'], 2));

        $sheet->setCellValue('A5', 'Down Payment');
        $sheet->setCellValue('B5', '$' . number_format($options['down_payment'], 2) . ' (' . $options['down_payment_rate'] . '%)');

        $sheet->setCellValue('A6', 'Loan Amount');
        $sheet->setCellValue('B6', '$' . number_format($options['loan_amount'], 2));

        $sheet->setCellValue('A7', 'Interest Rate');
        $sheet->setCellValue('B7', $options['interest_rate'] . '%');

        $sheet->setCellValue('A8', 'Term');
        $sheet->setCellValue('B8', $options['term'] . ' Years');

        // Monthly Payment Breakdown
        $sheet->setCellValue('A10', 'Monthly Payment Breakdown');
        $sheet->mergeCells('A10:D10');
        $sheet->getStyle('A10')->getFont()->setBold(true)->setSize(14);

        $sheet->setCellValue('A11', 'Principal & Interest');
        $sheet->setCellValue('B11', '$' . number_format($result['breakdown']['principal_and_interest'], 2));

        $sheet->setCellValue('A12', 'Taxes & HOA');
        $sheet->setCellValue('B12', '$' . number_format($result['breakdown']['taxes_and_hoa'], 2));

        $sheet->setCellValue('A13', 'Insurance');
        $sheet->setCellValue('B13', '$' . number_format($result['breakdown']['insurance'], 2));

        $sheet->setCellValue('A14', 'Monthly Insurance');
        $sheet->setCellValue('B14', '$' . number_format($result['breakdown']['monthly_insurance'], 2));

        $sheet->setCellValue('A16', 'TOTAL MONTHLY PAYMENT');
        $sheet->setCellValue('B16', '$' . number_format($result['total'], 2));
        $sheet->getStyle('A16:B16')->getFont()->setBold(true);

        // Additional Loan Details
        $sheet->setCellValue('A18', 'Additional Information');
        $sheet->mergeCells('A18:D18');
        $sheet->getStyle('A18')->getFont()->setBold(true)->setSize(14);

        $sheet->setCellValue('A19', 'Property Tax Rate');
        $sheet->setCellValue('B19', $options['property_tax'] . '%');

        $sheet->setCellValue('A20', 'Annual Insurance');
        $sheet->setCellValue('B20', '$' . number_format($options['annual_insurance'], 2));

        $sheet->setCellValue('A21', 'State');
        $sheet->setCellValue('B21', $options['state']);

        $sheet->setCellValue('A22', 'County');
        $sheet->setCellValue('B22', $options['county']);

        // Auto adjust column width
        foreach (range('A', 'D') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Save Excel file
        $excelFileName = 'mortgage_calculation_' . date('Y-m-d_His') . '.xlsx';
        $excelFilePath = storage_path('app/public/' . $excelFileName);

        $writer = new Xlsx($spreadsheet);
        $writer->save($excelFilePath);

        // Send email with attachment using Laravel Mail
        try {
            $data = [
                'options' => $options,
                'result' => $result
            ];

            Mail::send('emails.mortgage', $data, function ($message) use ($userEmail, $excelFilePath, $excelFileName) {
                $message->to($userEmail)
                    ->subject('Your Mortgage Calculation Details')
                    ->attach($excelFilePath, [
                        'as' => $excelFileName,
                        'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    ]);
            });

            $this->sendCalculatorAdminNotification($userEmail, $options, $result);

            // Delete temporary file
            unlink($excelFilePath);

            return response()->json([
                'success' => true,
                'message' => 'Mortgage calculation details have been emailed to ' . $userEmail,
                'data' => $request->all()
            ]);
        } catch (\Exception $e) {
            // Delete temporary file if it exists
            if (file_exists($excelFilePath)) {
                unlink($excelFilePath);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to send email: ' . $e->getMessage(),
                'data' => $request->all()
            ], 500);
        }
    }

    private function sendCalculatorAdminNotification($userEmail, $options, $result)
    {
        try {
            $adminEmail = SmtpSetting::getAdminEmail();

            if ($adminEmail) {
                $data = [
                    'userEmail' => $userEmail,
                    'options' => $options,
                    'result' => $result
                ];

                Mail::send('emails.admin.calculator-usage-notification', $data, function ($message) use ($adminEmail, $userEmail) {
                    $message->to($adminEmail)
                        ->subject('Mortgage Calculator Used by ' . $userEmail . ' - ' . now()->format('M d, Y H:i'));
                });
            }
        } catch (\Exception $e) {
            // Log error but don't break the main flow
            \Log::error('Failed to send calculator admin notification: ' . $e->getMessage());
        }
    }
}
