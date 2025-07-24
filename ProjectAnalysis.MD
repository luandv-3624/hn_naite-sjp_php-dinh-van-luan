### App có 4 roles:

-   Admin, guest, user, premium user

### Admin

-   ✅ Manage Users:
    -   Xem, chỉnh sửa, xóa người dùng,
    -   Gắn vai trò (user, premium user, guest)
-   ✅ Manage Expenses & Income Categories: Tạo, cập nhật, xóa danh mục chi tiêu/thu nhập chung

        -   Giống Monkey Lover:
            -   Chi tiêu thì có nhóm: Ăn Uống, Hóa đơn & Tiện ích: Thuê nhà, Hóa đơn nước,....
            -   Thu nhập chung thì có: Tiền lương, Tiền cho vay,...

-   ✅ Manage Feedback & Reports: Duyệt, phản hồi hoặc xử lý báo cáo từ người dùng

        -   Admin xử lý phản hồi (feedback) và báo cáo lỗi (reports) mà người dùng gửi.
        -   Ví dụ thực tế:

            -   Feedback: "Tôi muốn có thêm chức năng đồng bộ với ngân hàng X."

            -   Report: "Tôi không kết nối được tài khoản ngân hàng, báo lỗi 500."

        - Admin có thể:

         + Xem danh sách feedback/report.

         + Duyệt & phản hồi: trả lời người dùng, hoặc đánh dấu là "đã xử lý."

         + Chuyển tiếp hoặc tạo ticket cho kỹ thuật nếu đó là lỗi hệ thống.

-   ✅ Manage System Settings: Cấu hình giới hạn chi tiêu mặc định, đơn vị tiền tệ, API ngân hàng

        -   Ví dụ các thiết lập chính:

        + Giới hạn chi tiêu mặc định (Default Spending Limit):

            - Hệ thống có thể tự động gợi ý giới hạn chi tiêu cho người dùng mới.

            - Ví dụ: mặc định 10,000,000 VND / tháng cho danh mục "Ăn uống".

        + Đơn vị tiền tệ (Currency Settings):

            - Thêm /  Sửa / Xóa các đơn vị tiền tệ cho hệ thống

            - Chọn tiền tệ chính cho hệ thống: VND, USD, EUR. (kiểu admin chọn tiền tệ mặc định để khi user không chọn hệ thống sẽ gợi ý - VND)

        + API Ngân hàng (Bank API Settings):

            - Cấu hình kết nối với các ngân hàng hoặc ví điện tử.

            - Ví dụ: nhập API key và secret để kết nối với Open Banking

-   ✅ View System Revenue (from premium users): Báo cáo doanh thu từ các gói đăng ký

            - Đây là báo cáo doanh thu từ các gói Premium mà người dùng đăng ký trả phí.

            - Admin có thể xem:

            + Tổng doanh thu theo ngày / tháng / năm.

            + Danh sách người dùng trả phí (premium users).

            + Biểu đồ tăng trưởng doanh thu.

            Ví dụ:

            - Ngày 01/07/2025: 150 user premium → tổng doanh thu 15 triệu VND.

            - Biểu đồ cột hiển thị doanh thu 6 tháng gần nhất.

### Guest

-   ✅ View App Introduction: Giới thiệu chức năng, demo hệ thống

-   ✅ View Pricing Plans: Xem các gói dịch vụ (Miễn phí, Premium)

-   ✅ Register an Account: Đăng ký tài khoản (email, Google, Facebook)

-   ✅ View Blog, Financial Tips: Đọc bài viết chia sẻ mẹo quản lý tài chính

### User

-   ✅ Sign In / Sign Out

-   ✅ View Dashboard (Overview of Expense/Income): Chi tiêu / thu nhập

        - Tham khảo của Money Lover: có 2 tab là Tổng đã chi / Tổng thu (Tháng này):
            +   Cõ 1 slide hiển thị đồ thị: Tiền từng ngày (01/07 -> 31/07)
            +   Có 1 slide hiển thị biểu đò bar chart để so sánh tuần trước <-> tuần này, tháng trước <-> tháng này

-   ✅ Add / Edit / Delete Transaction: Ghi nhận chi tiêu, thu nhập

-   ✅ Categorize Transactions: Gắn giao dịch với danh mục
        
        - Thực ra phần này đã nằm trong bước tạo 'Giao dịch' ở trên (Theo Money Lover)

-   ✅ Recurring Transactions: Tạo giao dịch lặp định kỳ (tiền nhà, tiền điện)

-   ✅ Set Budget by Category: Đặt giới hạn chi tiêu theo danh mục (ăn uống, di chuyển,…)

        - Cái này tham khảo Money Lover (đã trải nghiệm)

-   ✅ Visual Reports (Pie chart, Bar chart, Calendar view)
        
        - Tham khảo phần "Sổ giao dịch > Xem báo cáo cho giai đoạn này" (Money Lover)

-   Link Bank Account / Import Bank Statement (CSV/Excel/Open Banking)

-   ✅ Manage Profile: Thông tin cá nhân, đổi mật khẩu

-   ✅ Upgrade to Premium via Payment Gateway: Nâng cấp tài khoản lên Premium

-   ✅ Comment on Financial Blog Posts

-   ✅ Like, Share Blog Articles

-   Set Financial Goals (Saving for car, vacation, etc.) 

        - Money Lover khong co 

-   ✅ Thiết lập ngân sách

### Premium User
-   Thiết lập mục tiêu tài chính (Financial Goals) 

-   Thiết lập ngân sách định kỳ

-   Nhận cảnh báo vượt ngân sách (Budget Exceed Alert) 

-   Tạo kế hoạch tiết kiệm định kỳ (Recurring Savings Plan)

-   Export Report (PDF, Excel): Xuất dữ liệu thu/chi

-   Kết nối tài khoản ngân hàng (Open Banking / OAuth)

-   Tự động import giao dịch từ sao kê ngân hàng

-   Thanh toán nâng cấp Premium qua Internet Banking/Ví điện tử
    
        - Ở đây sẽ sử dụng Momo / VNPay

-   ❓ Đồng bộ giao dịch qua API ngân hàng (nếu hỗ trợ)

## Other

#### [Activity]
Ghi nhận giao dịch chi tiêu
Ghi nhận thu nhập
Thiết lập ngân sách
Thiết lập mục tiêu tài chính
Nhận cảnh báo vượt ngân sách
Nâng cấp tài khoản
Tạo kế hoạch tiết kiệm định kỳ
Import file sao kê ngân hàng
Xuất báo cáo tài chính

#### [Banking / Payment]
❓ Kết nối tài khoản ngân hàng (Open Banking / OAuth)
✅ Thanh toán nâng cấp Premium qua Internet Banking/Ví điện tử
❓ Tự động import giao dịch từ sao kê ngân hàng
❓ Đồng bộ giao dịch qua API ngân hàng (nếu hỗ trợ)