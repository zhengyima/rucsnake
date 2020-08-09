import re
import os
import time

# 定期删除超时进程
while 1:
	time.sleep(1)
	os.system("top -n 1 > test.txt")
	with open("test.txt", "r") as file:
		for i, line in enumerate(file):
			if i >= 7:
				try:
					dur_time = re.search(":", line, flags=0).span()
					s = re.search("[1-2]01[3-9][0-9]+", line, flags=0).span()
					if s[1]-s[0] == 10:
						proc_id = line[s[0]:s[1]]
						dur_time = int(line[dur_time[0]+1:dur_time[0]+3])
						if dur_time > 1:
							os.system("pkill " + proc_id)
				except:
					pass
