mkdir -p test/build/phan

find -L src -type f -name '**.php' | grep -v blade.php | grep -v migrations | grep -v config | grep -v routes | grep -v views > test/build/phan/phan.in

phan -f test/build/phan/phan.in -o test/build/phan/phan.out -i

cat test/build/phan/phan.out
