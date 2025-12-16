# 📚 Hệ Thống Quản Lý Sinh Viên

Một ứng dụng web đơn giản để quản lý sinh viên sử dụng PHP và MySQL.

## ✨ Tính năng

- 🔐 **Đăng nhập Admin**: Đăng nhập bảo mật cho quản trị viên
- 👁️ **Xem danh sách sinh viên**: Hiển thị tất cả sinh viên trong hệ thống
- ➕ **Thêm sinh viên**: Thêm sinh viên mới vào cơ sở dữ liệu
- ✏️ **Sửa thông tin**: Cập nhật thông tin sinh viên
- ❌ **Xóa sinh viên**: Xóa sinh viên khỏi hệ thống
- 🔍 **Tìm kiếm**: Tìm kiếm sinh viên theo tên hoặc MSSV

## 📋 Yêu cầu

- PHP >= 7.0
- MySQL Server
- WAMP/XAMPP (hoặc máy chủ web khác hỗ trợ PHP)
- Web Browser

## 🚀 Cài đặt

1. **Sao chép tất cả các file vào thư mục dự án**
   ```
   c:\wamp64\www\qlsv_ftp_project\
   ```

2. **Mở WAMP/XAMPP và khởi động MySQL**

3. **Truy cập file setup để tạo database**
   ```
   http://localhost/qlsv_ftp_project/setup.php
   ```
   
   Nếu bạn thấy thông báo ✅ "Cập nhật database thành công", thì cơ sở dữ liệu đã được tạo.

4. **Truy cập ứng dụng**
   ```
   http://localhost/qlsv_ftp_project/login.php
   ```

## 🔑 Tài khoản mặc định

- **Username**: admin
- **Password**: 123456

## 📁 Cấu trúc File

```
qlsv_ftp_project/
├── config.php           # Cấu hình kết nối database
├── login.php            # Trang đăng nhập
├── process_login.php    # Xử lý đăng nhập
├── dashboard.php        # Danh sách sinh viên
├── add_student.php      # Thêm sinh viên
├── edit_student.php     # Sửa sinh viên
├── delete_student.php   # Xóa sinh viên
├── logout.php           # Đăng xuất
├── setup.php            # Tạo database (chạy 1 lần)
└── README.md            # Tài liệu này
```

## 🔄 Quy trình làm việc

1. **Đăng nhập**: Admin nhập username và password
2. **Xem danh sách**: Sau khi đăng nhập, xem danh sách tất cả sinh viên
3. **Thêm sinh viên**: Nhấn nút "+ Thêm sinh viên" và điền form
4. **Sửa sinh viên**: Nhấn "Sửa" trên dòng sinh viên cần sửa
5. **Xóa sinh viên**: Nhấn "Xóa" và xác nhận
6. **Tìm kiếm**: Nhập vào ô tìm kiếm để lọc sinh viên
7. **Đăng xuất**: Nhấn "Đăng xuất" để kết thúc phiên làm việc

## 📊 Thông tin Sinh viên

Mỗi sinh viên lưu trữ các thông tin sau:
- **MSSV**: Mã số sinh viên (duy nhất)
- **Họ tên**: Tên đầy đủ
- **Email**: Địa chỉ email
- **Số điện thoại**: Số liên lạc
- **Lớp**: Tên lớp học
- **Năm nhập học**: Năm bắt đầu học

## 🛡️ Bảo mật

- Mật khẩu được mã hóa bằng `password_hash` (bcrypt)
- Sử dụng Prepared Statements để ngăn SQL Injection
- Kiểm tra session để bảo vệ các trang quản lý

## 💡 Ghi chú

- Khi setup lần đầu, hệ thống sẽ tự động tạo tài khoản admin mặc định
- Mỗi MSSV phải duy nhất trong hệ thống
- Có thể chỉnh sửa mã nguồn để tùy chỉnh theo nhu cầu

## 📞 Hỗ trợ

Nếu gặp vấn đề khi cài đặt:
1. Kiểm tra MySQL Server có đang chạy không
2. Đảm bảo WAMP/XAMPP được khởi động
3. Kiểm tra quyền truy cập thư mục
4. Xóa database "student_management" và chạy setup.php lại

---
Tạo với ❤️ cho quản lý sinh viên hiệu quả
