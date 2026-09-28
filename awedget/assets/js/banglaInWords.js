function convertNumberToWords(amount) {
        var words = new Array();
        words[0] = '';
        words[1] = 'এক';
        words[2] = 'দুই';
        words[3] = 'তিন';
        words[4] = 'চার';
        words[5] = 'পাঁচ';
        words[6] = 'ছয়';
        words[7] = 'সাত';
        words[8] = 'আট';
        words[9] = 'নয়';
        words[10] = 'দশ';
        words[11] = 'এগার';
        words[12] = 'বার';
        words[13] = 'তের';
        words[14] = 'চোদ্দ';
        words[15] = 'পনের';
        words[16] = 'ষোল';
        words[17] = 'সতের';
        words[18] = 'আঠার';
        words[19] = 'উনিশ';
        words[20] = 'বিশ';
        words[21] = 'একুশ ';
        words[22] = 'বাইশ ';
        words[23] = 'তেইশ ';
        words[24] = 'চব্বিশ ';
        words[25] = 'পঁচিশ ';
        words[26] = 'ছাব্বিশ ';
        words[27] = 'সাতাশ';
        words[28] = 'আটাশ';
        words[29] = 'ঊনত্রিশ';
        words[30] = 'ত্রিশ';
        words[31] = 'একত্রিশ';
        words[32] = 'বত্রিশ';
        words[33] = 'তেত্রিশ';
        words[34] = 'চৌত্রিশ';
        words[35] = 'পঁয়ত্রিশ';
        words[36] = 'ছত্রিশ';
        words[37] = 'সাঁইত্রিশ';
        words[38] = 'আটত্রিশ';
        words[39] = 'ঊনচল্লিশ';
        words[40] = 'চল্লিশ';
        words[41] = 'একচল্লিশ';
        words[42] = 'বিয়াল্লিশ';
        words[43] = 'তেতাল্লিশ';
        words[44] = 'চুয়াল্লিশ';
        words[45] = 'পঁয়তাল্লিশ';
        words[46] = 'ছেচল্লিশ';
        words[47] = 'সাতচল্লিশ';
        words[48] = 'আটচল্লিশ';
        words[49] = 'ঊনপঞ্চাশ';
        words[50] = 'পঞ্চাশ';
        words[51] = 'একান্ন';
        words[52] = 'বায়ান্ন';
        words[53] = 'তিপ্পান্ন';
        words[54] = 'চুয়ান্ন';
        words[55] = 'পঞ্চান্ন';
        words[56] = 'ছাপ্পান্ন';
        words[57] = 'সাতান্ন';
        words[58] = 'আটান্ন';
        words[59] = 'ঊনষাট';
        words[60] = 'ষাট';
        words[61] = 'একষট্টি';
        words[62] = 'বাষট্টি';
        words[63] = 'তেষট্টি';
        words[64] = 'চৌষট্টি';
        words[65] = 'পঁয়ষট্টি';
        words[66] = 'ছেষট্টি';
        words[67] = 'সাতষট্টি';
        words[68] = 'আটষট্টি';
        words[69] = 'ঊনসত্তর';
        words[70] = 'সত্তর';
        words[71] = 'একাত্তর';
        words[72] = 'বাহাত্তর';
        words[73] = 'তিয়াত্তর';
        words[74] = 'চুয়াত্তর';
        words[75] = 'পঁচাত্তর';
        words[76] = 'ছিয়াত্তর';
        words[77] = 'সাতাত্তর';
        words[78] = 'আটাত্তর';
        words[79] = 'ঊনআশি';
        words[80] = 'আশি';
        words[81] = 'একাশি';
        words[82] = 'বিরাশি';
        words[83] = 'তিরাশি';
        words[84] = 'চুরাশি';
        words[85] = 'পঁচাশি';
        words[86] = 'ছিয়াশি';
        words[87] = 'সাতাশি';
        words[88] = 'আটাশি';
        words[89] = 'ঊননব্বই';
        words[90] = 'নব্বই';
        words[91] = 'একানব্বই';
        words[92] = 'বিরানব্বই';
        words[93] = 'তিরানব্বই';
        words[94] = 'চুরানব্বই';
        words[95] = 'পঁচানব্বই';
        words[96] = 'ছিয়ানব্বই';
        words[97] = 'সাতানব্বই';
        words[98] = 'আটানব্বই';
        words[99] = 'নিরানব্বই';
        
        amount = amount.toString();
        var atemp = amount.split(".");
        var number = atemp[0].split(",").join("");
        var n_length = number.length;
        var words_string = "";
        if (n_length <= 9) {
            var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
            var received_n_array = new Array();
            for (var i = 0; i < n_length; i++) {
                received_n_array[i] = number.substr(i, 1);
            }
            for (var i = 9 - n_length, j = 0; i < 9; i++, j++) {
                n_array[i] = received_n_array[j];
            }
            for (var i = 0, j = 1; i < 9; i++, j++) {
                if (i == 0 || i == 2 || i == 4 || i == 7) {
                    if (n_array[i] == 1) {
                        n_array[j] = 10 + parseInt(n_array[j]);
                        n_array[i] = 0;
                    }
                }
            }
            value = "";
            for (var i = 0; i < 9; i++) {
                if (i == 0 || i == 2 || i == 4 || i == 7) {
                    value = n_array[i] * 10;
                } else {
                    value = n_array[i];
                }
                if (value != 0) {
                    words_string += words[value] + " ";
                }
                if ((i == 1 && value != 0) || (i == 0 && value != 0 && n_array[i + 1] == 0)) {
                    words_string += "কোটি ";
                }
                if ((i == 3 && value != 0) || (i == 2 && value != 0 && n_array[i + 1] == 0)) {
                    words_string += "লক্ষ ";
                }
                if ((i == 5 && value != 0) || (i == 4 && value != 0 && n_array[i + 1] == 0)) {
                    words_string += "হাজার ";
                }
                if (i == 6 && value != 0 && (n_array[i + 1] != 0 && n_array[i + 2] != 0)) {
                    words_string += "শত এবং ";
                } else if (i == 6 && value != 0) {
                    words_string += "শত ";
                }
            }
            words_string = words_string.split("  ").join(" ");
        }
        return words_string;
}