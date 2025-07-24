# hn_naite-sjp_php-dinh-van-luan

## Database

### 1. Relationship Diagram
![alt text](<Personal Finance Management.png>)

### 2. Database description

**Role**
> Table roles {
  id int pk
  role_name enum // Enum: Admin , Guest, User, User Premiumm
}

**User Role**
> Table user_roles {
  user_id int
  role_id int
}

**User**

> Table users {
  id int pk
  username varchar
  email varchar
  password varchar
  provider_auth enum // Enum: email, google, facebook
  provider_user_id varchar
  premium_expired_at date
}

**Service Package**: các gói dịch vụ của hệ thống
>  Các gói dịch vụ
Để đơn giản thì ở đây ta sẽ chỉ tạo 1 loại gói Premium duy nhất
Sau khi user nâng cấp gói và thanh toán thì admin sẽ check 
và update role cho user lên premium user
> Table service_packages {
  id int pk
  title varchar // Premium
  description text 
  price decimal 
}

**User Service Package**: Ở đây App sẽ sử dụng Momo để cho người dùng thực hiện thanh toán
> Table user_service_packages {
  id int
  service_package_id int
  register_date datetime // ngày đăng ký 
  expire_date datetime // ngày hết hạn
  payment_method enum // Hỗ trợ: VNpay, Momo
  amount decimal // số tiền thanh toán 
  status enum // 3 trạng thái chính: Đã thanh toán, Chưa thanh toán, Đã hủy 
}

**Category**: Expenses & Income Categories: Danh mục chi tiêu/thu nhập
> Table categories {
  id int pk
  category_name varchar 
  type varchar // Khoản thu, Khoản chi, Vay / Nợ
  category_parent_id int // Ví dụ: Ăn uống, Nhóm Mua sắm: Đồ dùng cá nhân, Đồ gia dụng ,....
  created_by int
  default boolean // true: admin tạo làm nhóm chung
  wallet_type enum // Ví cơ bản, Ví tiết kiệm, Ví tín dụng, Ví liên kết (Chỉ enable với admin)
}

**Currency**: Danh sách đơn vị tiền tệ
> Table currencies {
  id int pk
  currency_name varchar // 	Tên tiền tệ (VD: Đồng Việt Nam, Đô la Mỹ)
  code varchar // VND, EUR, USD
  symbol varchar // Ký hiệu (VD: ₫, $, €)
  exchange_rate decimal // Tỷ giá so với tiền tệ mặc định của hệ thống (VD: VND = 25,000, USD = 1)
  is_default boolean // Tiền tệ mặc định của hệ thống
  updated_at datetime
}

**Wallet**: Ở đây để đơn giản sẽ chỉ thiết lập 2 loại ví: "Ví cơ bản", "Ví tiết kiệm"
> Table wallets {
  id int pk
  user_id int
  name varchar // VD: "Ví tiền mặt", "Ví của Luận",...
  balance decimal
  currency_id int
  wallet_type enum // BasicWallet, SavingWallet, CreditWallet, LinkWallet 
}

**Saving Wallet:** Ví tiết kiệm
> Table saving_wallet {
  id int pk
  wallet_id int
  target_amount decimal
  initial_amount decimal // chính là balance của wallet khi khởi tạo ví
  end_date datetime 
}

**Credit Wallet**: Ví tín dụng (optional) 
> Table credit_wallet {
  id int pk
  wallet_id int
  credit_limit decimal // Hạn mức tín dụng 
  statement_date datetime // Ngày sao kê
  payment_due_date datetime // Ngày đáo hạn
}

**Budget**: Ngân sách
> Table budgets {
  id int pk
  // user_id int 
  category_id int
  limit_amount decimal // Giới hạn chi tiêu 
  spent_amount decimal // Tổng đã chi trong kỳ
  // overspent_amount decimal // Bội chi (0 nếu chưa vượt ngân sách)
  wallet_use_scope enum // Total: tổng các ví của user, Wallet 1 ví tùy chọn của user
  wallet_id int // NULL nếu scope là total 
  start_date datetime // Tuần này / Tháng này / Quý này / Năm này / Tùy chỉnh
  end_date datetime
  is_recurring boolean // true = sau khi hết kỳ sẽ tự động reset kỳ mới
  recurring_type enum // Weekly, Monthly, Quarterly, Yearly (NULL nếu is_recurring = false)
                      // set kỳ hạn chỉ enable với start_date != tùy chỉnh
}

**Transaction**: Giao dịch - khi tạo giao dịch sẽ chọn ví
> Table transactions {
  id int pk
  wallet_id int 
  category_id int
  amount decimal // số tiền 
  note text
  is_recurring_transaction boolean // default: false
  recurring_transaction_id int
  date datetime 
}
Note: date - khi tạo 1 transaction sẽ check các budget cùng thuộc category có [start_date, end_date] chứa date, nếu valid => update progress của budget check cả wallet_use_scope của transaction == budget ngược lại, khi tạo budget cũng vậy

**Recurring Transaction**: Giao dịch lặp định kỳ
> Table recurring_transactions {
  id int pk   
  wallet_id        int // chỉ áp dụng cho Ví Cơ Bản  
  recurring_type   enum  // Daily, Weekly, Monthly, Quarterly, Yearly
  interval_value   int  // default 1, Số lần lặp mỗi chu kỳ (VD: 1 = mỗi tháng 1 lần, 2 = 2 tháng 1 lần)
  start_date       datetime  // Ngày bắt đầu lặp: > Ngày hiện tại
  end_date         datetime // nullable    // Ngày kết thúc lặp (NULL = vô thời hạn)
  created_at       datetime
  updated_at       datetime
}

**Blog**: chia sẻ về mẹo quản lý tài chính
> Table blogs {
  id int pk
  title varchar
  thumbnail_url varchar
  content text
  author_id int
  published_at datetime
  created_at datetime
  updated_at datetime
  status enum // draft, pending, rejected, pulished
  views int // số lượt xem
}

**Blog Comment**
> Table blog_comments {
  id int pk
  blog_id int
  user_id int
  content text
  parent_id int
  created_at datetime
}

**Blog Like**
> Table blog_likes {
  id int pk
  blog_id int
  user_id int
  created_at datetime
}

**Blog share**
> Table blog_shares {
  id int pk
  blog_id int 
  user_id int
  platform enum // Facebook
}

**Notification**: nhận thông báo chi tiêu vượt ngưỡng ngân sách
> Table notifications {
  id  int pk
  user_id          int    // User nhận thông báo
  noti_type        enum   // budget_overspend, budget_near_limit, new_blog_post, system_update, ...
  title            varchar// Tiêu đề thông báo (VD: "Bạn đã vượt ngân sách!")
  message          text   // Nội dung chi tiết (VD: "Ngân sách Ăn uống đã vượt 500.000₫")
  reference_type   enum   // Loại tham chiếu: Budget, Blog_post.
  reference_id     int    // ID tham chiếu (VD: budget_id)
  action_url       varchar// (Tùy chọn) Link để mở nhanh trong app/web (VD: /budgets/12)  
  is_read          boolean // Trạng thái đã đọc hay chưa
  created_at       datetime
}

**User Feedback Report**: Ở đây để đơn giản thì cho user tạo 1 feedback, report dạng text 
> Table user_feedback_reports {
  id  int pk
  user_id          int               // Người gửi
  type             enum              // Feedback: thuộc loại feedback, Report: thuộc loại báo cáo lỗi
  title            varchar           // Tiêu đề ngắn gọn
  content          text              // Nội dung chi tiết
  status           enum                // pending, in_progress, resolved, rejected
  admin_id         int // nullable      // Ai xử lý (Admin)
  admin_response   text // nullable     // Phản hồi của Admin
  created_at       datetime
  updated_at       datetime
  resolved_at      datetime // nullable // Ngày xử lý xong
}

#### Migrations
##### Create migration files
> php artisan make:migration create_roles_table --create=roles
php artisan make:migration create_user_roles_table --create=user_roles
php artisan make:migration create_service_packages_table --create=service_packages
php artisan make:migration create_user_service_packages_table --create=user_service_packages
php artisan make:migration create_currencies_table --create=currencies
php artisan make:migration create_wallets_table --create=wallets
php artisan make:migration create_saving_wallets_table --create=saving_wallets
php artisan make:migration create_credit_wallets_table --create=credit_wallets
php artisan make:migration create_categories_table --create=categories
php artisan make:migration create_budgets_table --create=budgets
php artisan make:migration create_recurring_transactions_table --create=recurring_transactions
php artisan make:migration create_transactions_table --create=transactions
php artisan make:migration create_blogs_table --create=blogs
php artisan make:migration create_blog_comments_table --create=blog_comments
php artisan make:migration create_blog_likes_table --create=blog_likes
php artisan make:migration create_blog_shares_table --create=blog_shares
php artisan make:migration create_notifications_table --create=notifications
php artisan make:migration create_user_feedback_reports_table --create=user_feedback_reports
