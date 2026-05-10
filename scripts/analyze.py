#!/usr/bin/env python3
"""
Verdant Analytics - Phân tích dữ liệu khách hàng
Phân tích xu hướng mua hàng theo giới tính và độ tuổi.
Sử dụng: python analyze.py <path_to_sqlite_db>
"""

import sqlite3
import json
import sys
from datetime import datetime, date
from collections import defaultdict


def get_age(birthdate_str):
    """Calculate age from birthdate string."""
    if not birthdate_str:
        return None
    try:
        bd = datetime.strptime(birthdate_str, "%Y-%m-%d").date()
        today = date.today()
        return today.year - bd.year - ((today.month, today.day) < (bd.month, bd.day))
    except (ValueError, TypeError):
        return None


def get_age_group(age):
    """Get age group label."""
    if age is None:
        return None
    if age < 25:
        return "18-24"
    elif age < 35:
        return "25-34"
    elif age < 45:
        return "35-44"
    elif age < 55:
        return "45-54"
    else:
        return "55+"


def analyze(db_path):
    """Main analysis function."""
    conn = sqlite3.connect(db_path)
    conn.row_factory = sqlite3.Row
    cursor = conn.cursor()

    results = {}

    # ===== 1. PHÂN TÍCH GIỚI TÍNH =====
    cursor.execute("""
        SELECT gender, COUNT(*) as total 
        FROM users WHERE gender IS NOT NULL 
        GROUP BY gender
    """)
    results["gender_distribution"] = {row["gender"]: row["total"] for row in cursor.fetchall()}

    # ===== 2. PHÂN TÍCH ĐỘ TUỔI =====
    cursor.execute("SELECT birthdate FROM users WHERE birthdate IS NOT NULL")
    age_groups = defaultdict(int)
    for row in cursor.fetchall():
        age = get_age(row["birthdate"])
        group = get_age_group(age)
        if group:
            age_groups[group] += 1
    results["age_distribution"] = dict(age_groups)

    # ===== 3. SẢN PHẨM YÊU THÍCH THEO GIỚI TÍNH =====
    cursor.execute("""
        SELECT u.gender, oi.plant_name, oi.plant_slug,
               SUM(oi.quantity) as total_qty,
               SUM(oi.price * oi.quantity) as total_revenue
        FROM order_items oi
        JOIN orders o ON oi.order_id = o.id
        JOIN users u ON o.user_id = u.id
        WHERE u.gender IS NOT NULL
        GROUP BY u.gender, oi.plant_slug
        ORDER BY u.gender, total_qty DESC
    """)
    
    favorites_by_gender = defaultdict(list)
    for row in cursor.fetchall():
        favorites_by_gender[row["gender"]].append({
            "plant_name": row["plant_name"],
            "plant_slug": row["plant_slug"],
            "total_qty": row["total_qty"],
            "total_revenue": row["total_revenue"],
        })
    # Keep top 5 per gender
    results["favorites_by_gender"] = {
        g: items[:5] for g, items in favorites_by_gender.items()
    }

    # ===== 4. SẢN PHẨM YÊU THÍCH THEO ĐỘ TUỔI =====
    cursor.execute("""
        SELECT u.birthdate, oi.plant_name, oi.plant_slug,
               SUM(oi.quantity) as total_qty,
               SUM(oi.price * oi.quantity) as total_revenue
        FROM order_items oi
        JOIN orders o ON oi.order_id = o.id
        JOIN users u ON o.user_id = u.id
        WHERE u.birthdate IS NOT NULL
        GROUP BY u.birthdate, oi.plant_slug
    """)
    
    favorites_by_age = defaultdict(lambda: defaultdict(lambda: {"total_qty": 0, "total_revenue": 0, "plant_name": "", "plant_slug": ""}))
    for row in cursor.fetchall():
        age = get_age(row["birthdate"])
        group = get_age_group(age)
        if group:
            slug = row["plant_slug"]
            favorites_by_age[group][slug]["plant_name"] = row["plant_name"]
            favorites_by_age[group][slug]["plant_slug"] = slug
            favorites_by_age[group][slug]["total_qty"] += row["total_qty"]
            favorites_by_age[group][slug]["total_revenue"] += row["total_revenue"]

    # Sort and keep top 5
    results["favorites_by_age"] = {}
    for group, plants in favorites_by_age.items():
        sorted_plants = sorted(plants.values(), key=lambda x: x["total_qty"], reverse=True)
        results["favorites_by_age"][group] = sorted_plants[:5]

    # ===== 5. GỢI Ý POPUP QUẢNG CÁO =====
    popup_recommendations = []

    # Popup logic: Tìm sản phẩm phù hợp nhất cho từng nhóm demographics
    for gender in ["male", "female"]:
        gender_items = favorites_by_gender.get(gender, [])
        if gender_items:
            top = gender_items[0]
            popup_recommendations.append({
                "target_gender": gender,
                "target_age": None,
                "plant_slug": top["plant_slug"],
                "plant_name": top["plant_name"],
                "reason": f"San pham ban chay nhat voi {'nam' if gender == 'male' else 'nu'} gioi"
            })

    for age_group in ["18-24", "25-34", "35-44"]:
        age_items = results["favorites_by_age"].get(age_group, [])
        if age_items:
            top = age_items[0]
            popup_recommendations.append({
                "target_gender": None,
                "target_age": age_group,
                "plant_slug": top["plant_slug"],
                "plant_name": top["plant_name"],
                "reason": f"San pham duoc yeu thich nhat boi nhom tuoi {age_group}"
            })

    results["popup_recommendations"] = popup_recommendations

    # ===== 6. TỔNG QUAN =====
    cursor.execute("SELECT COUNT(*) as total FROM users")
    total_users = cursor.fetchone()["total"]
    cursor.execute("SELECT COUNT(*) as total FROM orders")
    total_orders = cursor.fetchone()["total"]
    cursor.execute("SELECT COALESCE(SUM(total_amount), 0) as total FROM orders")
    total_revenue = cursor.fetchone()["total"]

    results["summary"] = {
        "total_users": total_users,
        "total_orders": total_orders,
        "total_revenue": total_revenue,
        "avg_order_value": round(total_revenue / total_orders) if total_orders > 0 else 0,
        "analyzed_at": datetime.now().isoformat(),
    }

    conn.close()
    return results


if __name__ == "__main__":
    if len(sys.argv) < 2:
        print(json.dumps({"error": "Usage: python analyze.py <db_path>"}))
        sys.exit(1)

    db_path = sys.argv[1]
    try:
        result = analyze(db_path)
        print(json.dumps(result, ensure_ascii=False, indent=2))
    except Exception as e:
        print(json.dumps({"error": str(e)}))
        sys.exit(1)
